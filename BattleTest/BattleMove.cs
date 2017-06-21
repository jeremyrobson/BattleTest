using System.Collections.Generic;
using System.Drawing;
using System.Linq;

namespace BattleTest
{
    public class BattleMove : IQueueable
    {
        BattleUnit unit;
        MoveNode node;
        List<MoveNode> path;
        public List<MoveNode> moveNodes;

        public int ID { get; set; }
        public bool Ready { get; set; }
        public bool Remove { get; set; }
        public bool Done { get; set; }
        public int CT { get; set; }
        public int CTR { get; set; }
        public int Priority { get; set; }
        public int Speed { get; set; }

        public BattleMove(BattleUnit unit, MoveNode node, List<MoveNode> moveNodes)
        {
            this.unit = unit;
            this.node = node;
            this.moveNodes = moveNodes;

            path = BattleMap.getPath(node);
            CTR = 0;
            Ready = true;
            Priority = 1;
            ID = GameBattle.generateID();

            //restrict path to unit's move limit
            if (path.Count > unit.moveLimit)
            {
                path = path.Take(unit.moveLimit).ToList();
            }
        }

        public void tick()
        {

        }

        public void invoke(BattleMap map, List<BattleUnit> units, BattleQueue queue)
        {
            if (path.Count > 0)
            {
                GameBattle.WriteLine("BattleMove: " + unit.name + " moved to " + path[0].x + ", " + path[0].y);
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
            Remove = true;
            Done = true;
        }

        public void draw(Graphics g)
        {
            node.recursiveDraw(g);
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
