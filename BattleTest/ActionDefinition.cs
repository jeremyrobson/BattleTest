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
        public string name;
        public int range;
        public List<Point> spread;

        public static ActionDefinition melee
        {
            get
            {
                ActionDefinition melee = new ActionDefinition();
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

        public static ActionDefinition nothing
        {
            get
            {
                ActionDefinition nothing = new ActionDefinition();
                nothing.name = "Nothing";
                nothing.range = 0;
                nothing.spread = new List<Point>();
                return nothing;
            }
        }
    }
}
