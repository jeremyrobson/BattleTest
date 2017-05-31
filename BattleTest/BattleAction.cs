using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class BattleAction : IQueueable, IComparable<BattleAction>
    {
        public BattleUnit actor;
        //public int range;
        public List<Point> spread;
        public int targetX;
        public int targetY;
        public MoveNode node;
        public double score;
        public double distance;
        public int damage;
        public ActionDefinition actiondef;

        public bool Ready { get; set; }
        public bool Remove { get; set; }
        public int CT { get; set; }
        public int CTR { get; set; }
        public int Priority { get; set; }

        public BattleAction(BattleUnit actor)
        {
            this.actor = actor;
            Priority = 1;
        }

        public void tick()
        {
            if (CTR <= 0)
            {
                CTR = 0;
                Ready = true;
            }
            else
            {
                CTR -= 1;
                if (CTR <= 0)
                {
                    CTR = 0;
                    Ready = true;
                }
            }
        }

        public void invoke(BattleMap map, List<BattleUnit> units, BattleQueue queue)
        {
            List<ITargetable> targets = new List<ITargetable>();

            spread.ForEach(s => {
                ITargetable target = map.getTileUnits(s.X, s.Y)[0];
                if (target != null)
                {
                    targets.Add(target);
                }
            });

            targets.ForEach(target => {
                var damages = getDamage(actor, target, actiondef);
                GameBattle.WriteLine(actor.name + " used " + actiondef.name + " on " + ((BattleUnit) target).name + " for " + damages + " damages.");
            });

            done();
        }

        public void done()
        {
            Remove = true;
            actor.action = null;
            actor.acted = true;
        }

        public bool mustMoveFirst()
        {
            return (!(actor.x == node.x && actor.y == node.y));
        }

        public void draw(Graphics g)
        {

        }

        public int CompareTo(IQueueable item)
        {
            if (CTR < item.CTR) return -1;
            if (CTR > item.CTR) return 1;
            if (Priority > item.Priority) return -1;
            if (Priority < item.Priority) return 1;
            return 0; //this should never happen
        }

        public int CompareTo(BattleAction action)
        {
            if (score < action.score) return -1;
            if (score > action.score) return 1;
            return 0;
        }

        public override string ToString()
        {
            return "Action - " + actor.sprite + " - CTR: " + CTR + ", Node: " + targetX + ", " + targetY;
        }

        public static List<Point> createDiamond(int x, int y, int range, int maxWidth, int maxHeight, bool includeCenter)
        {
            List<Point> diamond = new List<Point>();
            
            for (var i = -range; i <= range; i++)
            {
                for (var j = -range; j <= range; j++)
                {
                    if (!includeCenter && i == 0 && j == 0)
                    {
                        continue;
                    }
                    else if (Math.Abs(i) + Math.Abs(j) <= range)
                    {
                        var dx = i + x;
                        var dy = j + y;
                        if (dx >= 0 && dy >= 0 && dx < maxWidth && dy < maxHeight)
                        {
                            diamond.Add(new Point(i + x, j + y));
                        }
                    }
                }
            }

            return diamond;
        }

        public static int getDamage(BattleUnit actor, ITargetable target, ActionDefinition action)
        {
            Random random = new Random();
            int damage = random.Next(1, 7) + random.Next(1, 7);

            return damage;
        }

        public static double getScore(BattleUnit actor, ITargetable target, int damage)
        {
            double score = 0;

            if (target is BattleUnit)
            {
                if (actor.team == ((BattleUnit) target).team) // okay...
                {
                    score -= damage;
                }
                else
                {
                    score += damage;
                }
            }

            return score;
        }

        public static BattleAction getDefaultAction(BattleUnit actor)
        {
            BattleAction defaultAction = new BattleAction(actor);

            defaultAction.node = new MoveNode(actor.x, actor.y, 0, null);
            defaultAction.actiondef = ActionDefinition.nothing;
            defaultAction.spread = new List<Point>();

            return defaultAction;
        }

        //generate action coverage for a particular unit
        public static List<BattleAction> generateCoverage(BattleMap map, List<BattleUnit> units, BattleUnit unit)
        {
            double min = 0, max = 1;
            List<BattleAction> coverage = new List<BattleAction>();
            coverage.Add(getDefaultAction(unit));

            List<MoveNode> mapNodes = BattleMap.getMapNodes(map.tiles, GameBattle.MAP_WIDTH, GameBattle.MAP_HEIGHT, units, unit, -999); //list of possible move nodes

            mapNodes = mapNodes.Where(node => node.steps <= unit.moveLimit).ToList();

            GameBattle.mapNodes = mapNodes;

            unit.jobclass.actions.ForEach(actiondef => {
                mapNodes.ForEach(node => {
                    var diamond = createDiamond(node.x, node.y, actiondef.range, GameBattle.MAP_WIDTH, GameBattle.MAP_HEIGHT, false); //list of possible action nodes
                    diamond.ForEach(d => {
                        List<Point> newspread = new List<Point>();
                        int totalDamage = 0;
                        double totalScore = 0;

                        actiondef.spread.ForEach(s => {
                            int x = s.X + d.X;
                            int y = s.Y + d.Y;

                            if (BattleMap.inRange(x, y)) //if target node is in range
                            {

                                //save spread so queue can see if action contains point (or something like that)
                                newspread.Add(new Point(x, y));    

                                BattleUnit target = null;

                                if (x == node.x && y == node.y) //is this where the actor is moving to?
                                { 
                                    target = unit; //then he hits himself
                                }
                                else
                                {
                                    target = map.getFirstTileUnit(x, y); //get the unit at target node
                                }

                                if (target != null)
                                {
                                    int damage = getDamage(unit, target, actiondef); //get damage
                                    totalScore += getScore(unit, target, damage); //get score from damage
                                    totalDamage += damage; //add damage to running total for this action
                                }
                            }
                        });

                        //if nothing was accomplished in the spread, ignore this action node
                        if (totalScore <= 0)
                        {
                            return;
                        }

                        int dx = d.X - node.x;
                        int dy = d.Y - node.y;
                        double distance = Math.Sqrt(dx * dx + dy * dy); //distance from action node to move node

                        totalScore += distance; //todo: for ranged attacks higher is better, for ranged buffs lower is better

                        BattleAction battleAction = new BattleAction(unit);
                        battleAction.actiondef = actiondef;
                        battleAction.node = node;
                        battleAction.targetX = d.X;
                        battleAction.targetY = d.Y;
                        battleAction.distance = distance;
                        battleAction.damage = totalDamage;
                        battleAction.score = totalScore;
                        battleAction.spread = newspread;

                        coverage.Add(battleAction);

                        min = totalScore < min ? totalScore : min;
                        max = totalScore > max ? totalScore : max;
                    }); //diamond
                }); //mapNodes
            }); //actions

            //normalization of scores
            coverage.ForEach(c => {
                c.score = (c.score - min) / (max - min);
            });

            coverage.Sort();

            return coverage;
        }
    }

}
