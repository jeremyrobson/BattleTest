using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class BattleMove : IQueueable
    {
        BattleUnit unit;
        MoveNode node;
        List<MoveNode> path;

        public bool Ready { get; set; }
        public bool Remove { get; set; }
        public int CT { get; set; }
        public int CTR { get; set; }
        public int Priority { get; set; }

        public BattleMove(BattleUnit unit, MoveNode node)
        {
            this.unit = unit;
            this.node = node;

            path = BattleMap.getPath(node);
            CTR = 0;
            Ready = true;
            Priority = 1;
            Remove = false;

            //restrict path to unit's move limit
            if (path.Count > unit.moveLimit)
            {
                this.path = this.path.Take(unit.moveLimit).ToList();
            }
        }

        public void tick()
        {

        }

        public void invoke(BattleMap map, List<BattleUnit> units, BattleQueue queue)
        {
            GameBattle.WriteLine("BattleMove: move invoke");

            if (path.Count > 0)
            {
                var node = path[0];
                path.RemoveAt(0);
                map.moveUnit(ref unit, node.x, node.y);
            }
            else
            {
                done();
            }
        }

        public void done()
        {
            unit.moved = true;
            Remove = true;
        }

        public void draw(Graphics g)
        {
            MoveNode n = node;
            while (n != null)
            {
                n.draw(g);
                n = n.parent;
            }
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
            return "Move - " + unit.name + " - CTR: " + CTR + ", Node: " + node.x + ", " + node.y;
        }
    }
}
