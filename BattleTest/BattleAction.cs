﻿using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;

namespace BattleTest
{
    public class BattleAction : IQueueable, IComparable<BattleAction>
    {
        public BattleUnit actor;
        public List<Point> diamond;
        public List<MoveNode> moveNodes;
        public ITargetable target;
        //public List<MoveNode> nodeList;
        public MoveNode node;
        public double score;
        public double distance;
        public int damage;
        public ActionDefinition actiondef;

        public int ID { get; set; }
        public bool Ready { get; set; }
        public bool Remove { get; set; }
        public bool Done { get; set; }
        public int CT { get; set; }
        public int CTR { get; set; }
        public int Priority { get; set; }
        public int Speed { get; set; }

        static Brush rangeBrush;
        static Brush spreadBrush;

        //spread depends on where target is
        public List<Point> Spread
        {
            get
            {
                List<Point> spread = new List<Point>();
                actiondef.spread.ForEach(p =>
                {
                    spread.Add(new Point(p.X + target.X, p.Y + target.Y));
                });
                return spread;
            }
        }

        public BattleAction(BattleUnit actor, ActionDefinition actiondef)
        {
            this.actor = actor;
            this.actiondef = actiondef;
            CTR = BattleQueue.calculateCTR(100, actiondef.speed);
            Priority = 2;
            ID = GameBattle.generateID();

            //rangeBrush = new SolidBrush(Color.FromArgb(255, 255, 0, 0));
            spreadBrush = new SolidBrush(Color.FromArgb(255, 0, 255, 0));
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

            Spread.ForEach(s => {
                ITargetable target = map.getFirstTileUnit(s.X, s.Y);
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
            Done = true;
            Remove = true;
            actor.action = null;
        }

        public bool mustMoveFirst()
        {
            return (!(actor.X == node.x && actor.Y == node.y));
        }

        public void draw(Graphics g)
        {
            /*
            if (diamond != null)
            {
                diamond.ForEach(point => g.FillRectangle(
                    rangeBrush,
                    point.X * GameBattle.TILE_WIDTH,
                    point.Y * GameBattle.TILE_HEIGHT,
                    GameBattle.TILE_WIDTH,
                    GameBattle.TILE_HEIGHT
                ));
            }
            */
            
            Spread.ForEach(point => g.FillRectangle(
                spreadBrush,
                point.X * GameBattle.TILE_WIDTH,
                point.Y * GameBattle.TILE_HEIGHT,
                GameBattle.TILE_WIDTH,
                GameBattle.TILE_HEIGHT
            ));

        }

        public int CompareTo(IQueueable item)
        {
            if (CTR < item.CTR) return -1;
            if (CTR > item.CTR) return 1;
            if (Priority < item.Priority) return -1;
            if (Priority > item.Priority) return 1;
            if (ID < item.ID) return -1;
            if (ID > item.ID) return 1;
            return 0; //this should never happen
        }

        //sort DESC
        public int CompareTo(BattleAction action)
        {
            if (score < action.score) return 1;
            if (score > action.score) return -1;
            return 0;
        }

        public override string ToString()
        {
            return "Action - " + actor.sprite + " - CTR: " + CTR + ", Node: " + target.X + ", " + target.Y;
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
            BattleAction defaultAction = new BattleAction(actor, ActionDefinition.nothing);

            defaultAction.node = new MoveNode(actor.X, actor.Y, 0, null);

            return defaultAction;
        }

        //generate action coverage for a particular unit
        public static List<BattleAction> generateCoverage(BattleMap map, List<BattleUnit> units, BattleUnit unit)
        {
            double min = 0, max = 1;
            List<BattleAction> coverage = new List<BattleAction>();
            coverage.Add(getDefaultAction(unit));

            //if currently charging action, add it to coverage as well to see if it is worth switching
            if (unit.action != null)
            {
                int damage = getDamage(unit, unit.action.target, unit.action.actiondef);
                unit.action.score = getScore(unit, unit.action.target, damage);
                coverage.Add(unit.action);
            }

            List<MoveNode> moveNodes = new List<MoveNode>();
            
            //if already moved, generate move nodes for current position only
            if (unit.moved)
            {
                moveNodes.Add(new MoveNode(unit.X, unit.Y, 0, null));
            }
            else //generate all move nodes using pathfinding algorithm
            {
                moveNodes = BattleMap.getMoveNodes(map.tiles, GameBattle.MAP_WIDTH, GameBattle.MAP_HEIGHT, units, unit, -999, true); //list of possible move nodes
                moveNodes = moveNodes.Where(node => node.steps <= unit.moveLimit).ToList();
            }

            unit.jobclass.actions.ForEach(actiondef => {
                moveNodes.ForEach(node => {
                    var diamond = createDiamond(node.x, node.y, actiondef.range, GameBattle.MAP_WIDTH, GameBattle.MAP_HEIGHT, false); //list of possible action nodes
                    diamond.ForEach(d => {
                        int totalDamage = 0;
                        double totalScore = 0;
                        int actionCTR = BattleQueue.calculateCTR(100, actiondef.speed);
                        bool sticky = false;

                        actiondef.spread.ForEach(s => {
                            int x = s.X + d.X;
                            int y = s.Y + d.Y;

                            if (BattleMap.inRange(x, y)) //if target node is in range
                            {
                                BattleUnit target = null;

                                if (x == node.x && y == node.y) //is this where the actor is moving to?
                                { 
                                    target = unit; //then he will hit himself
                                }
                                else
                                {
                                    target = map.getFirstTileUnit(x, y); //get the unit at spread node

                                    //if target is actor but actor will move before it hits
                                    if (target != null && unit.Equals(target) && (node.x != unit.X || node.y != unit.Y))
                                    {
                                        target = null; //ignore actor
                                    }

                                    //if action will be invoked after target's turn (target has opportunity to move)
                                    if (target != null && target.CTR < actionCTR)
                                    {
                                        if (actiondef.sticky) //action can stick
                                        {
                                            sticky = true;
                                        }
                                        else //action cannot stick
                                        {
                                            target = null; //ignore target
                                        }
                                    }

                                    //if action will invoke before target's turn
                                    if (target != null & target.CTR >= actionCTR)
                                    {
                                        //pass
                                    }

                                    //if target is to be killed before action is invoked
                                    if (target != null)
                                    {
                                        int futureDamage = BattleQueue.getTargetFutureDamage(unit, target, actionCTR);
                                        if (futureDamage > target.hp)
                                        {
                                            target = null; //ignore target
                                        }
                                    }
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

                        totalScore += node.SafetyScore;

                        int dx = d.X - node.x;
                        int dy = d.Y - node.y;
                        double distance = Math.Sqrt(dx * dx + dy * dy); //distance from action node to move node                        
                        totalScore += distance; //todo: for ranged attacks higher is better, for ranged buffs lower is better

                        BattleAction battleAction = new BattleAction(unit, actiondef);
                        battleAction.node = node;
                        battleAction.distance = distance;
                        battleAction.damage = totalDamage;
                        battleAction.score = totalScore;
                        battleAction.moveNodes = moveNodes;
                        battleAction.diamond = diamond;

                        if (sticky)
                        {
                            battleAction.target = GameBattle.getMap().getFirstTileUnit(d.X, d.Y);
                        }

                        if (battleAction.target == null)
                        {
                            battleAction.target = GameBattle.getMap().tiles[d.X, d.Y];
                        }

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
