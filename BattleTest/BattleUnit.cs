using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;

namespace BattleTest
{
    class BattleUnit : IQueueable, ITargetable, IDrawable, IEquatable<BattleUnit>
    {
        static Random random;

        public int x;
        public int y;
        public string name;
        public string team;
        public string sprite;
        public BattleAction action;
        public BattleMove move; //todo: figure out if this is needed for anything
        public int moveLimit = 3;
        public int hp;
        public string status;
        public JobClass jobclass;

        public int ID { get; set; }
        public int CT { get; set; }
        public int CTR { get; set; }
        public int Priority { get; set; }
        public int Speed { get; set; }
        public bool Ready { get; set; }
        public bool Remove { get; set; }
        public bool Done { get; set; }

        public bool moved = false;
        public bool acted = false;

        Brush brush;
        Font font;

        public BattleUnit(string name, string team, int x, int y)
        {
            if (random == null)
            {
                random = new Random();
            }

            ID = GameBattle.generateID();
            this.name = name;
            sprite = name[0].ToString();
            this.team = team;
            this.x = x;
            this.y = y;
            hp = 100;
            status = "alive";

            jobclass = JobClass.squire;
            Speed = 5; // random.Next(3, 10);
            Priority = 0;
            CTR = 0;
            CT = 100;

            if (team == "cpu1")
            {
                brush = Brushes.ForestGreen;
            }
            else
            {
                brush = Brushes.Fuchsia;
            }

            font = new Font("Arial", 16.0f);

            done();
        }

        public void tick()
        {
            if (CTR <= 0)
            {
                CTR = 0;
                Ready = true;
                Done = false;
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
            GameBattle.WriteLine(name + " invoked");

            //this.safetyMap = generateSafetyMap(battle.units, this);
            List<BattleAction> coverage = BattleAction.generateCoverage(map, units, this);

            if (!moved && !acted)
            {
                if (action != null)
                {
                    GameBattle.WriteLine(name + " is already preparing to act.");
                    //todo: if action is sticky, allow movement
                    acted = true;
                }
                else
                {
                    action = coverage.First();  //supposedly the best action

                    //if action requires move
                    if (action.node.x != x || action.node.y != y)
                    {
                        move = new BattleMove(this, action.node, action.moveNodes);
                        queue.add(move);
                        moved = true;
                        action = null; //will get new action after move is completed
                    }
                    else
                    {
                        queue.add(action);
                        acted = true;
                        GameBattle.WriteLine(name + " queued an action called " + action.actiondef.name);
                    }
                }
            }
            else if (acted && !moved)
            {
                GameBattle.WriteLine("Moving to a safer location.");

                List<MoveNode> moveNodes = BattleMap.getMoveNodes(map.tiles, GameBattle.MAP_WIDTH, GameBattle.MAP_HEIGHT, units, this, moveLimit, true);

                moveNodes.Sort();

                MoveNode newNode = moveNodes[0];
                move = new BattleMove(this, newNode, action.moveNodes);
                queue.add(move);

                //only counts as move if actually moved
                if (newNode.x != x || newNode.y != y)
                {
                    moved = true;
                }

                done();
            }
            else if (!acted && moved)
            {
                if (action != null)
                {
                    GameBattle.WriteLine(name + " is already preparing to act!!!");
                }
                else
                {
                    action = coverage[0];
                    queue.add(action);
                    acted = true;
                    GameBattle.WriteLine(name + " queued an action called " + action.actiondef.name);
                }
                
                done();
            }
            else
            {
                GameBattle.WriteLine("This should never happen.");
                done();
            }
        }

        public void done()
        {
            if (moved && acted)
            {
                CT = 100;
            }
            else if (moved)
            {
                CT = 80;
            }
            else if (acted)
            {
                CT = 80;
            }
            else
            {
                CT = 60;
            }
            CTR = BattleQueue.calculateCTR(CT, Speed);
            Ready = false;
            moved = false;
            acted = false;
            Done = true;
        }

        public void draw(Graphics g)
        {
            float dx = GameBattle.TILE_WIDTH * x;
            float dy = GameBattle.TILE_HEIGHT * y;
            g.DrawString(sprite, font, brush, dx, dy);
        }
        
        public int CompareTo(IQueueable item)
        {
            if (CTR < item.CTR) return -1;
            if (CTR > item.CTR) return 1;
            if (Priority > item.Priority) return -1;
            if (Priority < item.Priority) return 1;
            if (ID < item.ID) return -1;
            if (ID > item.ID) return 1;
            return 0; //this should never happen
        }

        public bool Equals(BattleUnit unit)
        {
            if (unit == null)
            {
                return false;
            }
            return ID == unit.ID;
        }

        public override string ToString()
        {
            return "Unit " + name + " CTR: " + CTR + " Moved: " + moved + " Acted:" + acted;
        }
    }
}
