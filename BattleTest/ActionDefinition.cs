using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class ActionDefinition
    {
        public static ActionDefinition melee;

        public string name;
        public int range;
        public List<Point> spread;

        public static ActionDefinition singleton()
        {
            melee = new ActionDefinition();
            melee.name = "Melee";
            melee.range = 3;
            melee.spread = new List<Point>();
            melee.spread.Add(new Point(-1, 0));
            melee.spread.Add(new Point(0, -1));
            melee.spread.Add(new Point(1, 0));
            melee.spread.Add(new Point(0, 1));

            return melee;
        }
    }
}
