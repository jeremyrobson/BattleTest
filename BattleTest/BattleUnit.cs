using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class BattleUnit : IQueueable, ITargetable, IDrawable
    {
        static Random random;

        static int count;
        public int id;
        public int x;
        public int y;
        public string name;
        public string team;
        public string sprite;
        public BattleAction action;
        public int moveLimit = 5;
        public int agl;
        public string status;
        public JobClass jobclass;

        public int CT { get; set; }
        public int CTR { get; set; }
        public int Priority { get; set; }
        public bool Ready { get; set; }
        public bool Remove { get; set; }

        public bool moved = false;
        public bool acted = false;

        Brush brush;
        Font font;

        public BattleUnit(string name, string team, int x, int y)
        {
            count++;

            if (random == null)
            {
                random = new Random();
            }

            id = count;
            this.name = name;
            sprite = name[0].ToString();
            this.team = team;
            this.x = x;
            this.y = y;

            jobclass = JobClass.squire;
            agl = random.Next(3, 10);
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
                    GameBattle.WriteLine("Unit No. " + action.actor.name + " is already preparing to act.");
                    //todo: if action is sticky, allow movement
                    acted = true;
                }
                else
                {
                    action = coverage.First();  //supposedly the best action

                    //requires move
                    if (action.node.x != x || this.action.node.y != y)
                    {
                        queue.add(new BattleMove(this, action.node));
                        //queue.add(this.actionmove);  //why is this here???
                        moved = true;
                    }
                    else
                    {
                        queue.add(action);
                        acted = true;
                    }
                }
            }
            else if (acted && !moved)
            {
                queue.add(new BattleMove(this, coverage[0].node));
                done();
            }
            else if (!acted && moved)
            {
                if (action != null)
                {
                    GameBattle.WriteLine("I SAID Unit No. " + action.actor.name + " is already preparing to act!!!");
                }
                else
                {
                    action = coverage[0];
                    queue.add(action);
                }
                acted = true;
                done();
            }
            else
            {
                //battle.queue.add(new DoNothing(battle, this));
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
            CTR = (int) Math.Ceiling((double) this.CT / this.agl);
            Ready = false;
            moved = false;
            acted = false;
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
            return 0; //this should never happen
        }

        public override string ToString()
        {
            return "Unit " + name + " CTR: " + CTR;
        }
    }
}
