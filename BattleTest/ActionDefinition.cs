using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    public class ActionDefinition
    {
        public string name;
        public int speed;
        public int range;
        public List<Point> spread;
        public bool sticky;
        public int CTCost;

        public static ActionDefinition melee
        {
            get
            {
                ActionDefinition melee = new ActionDefinition();
                melee.name = "Melee";
                melee.speed = 10;
                melee.range = 3;
                melee.sticky = false;
                melee.CTCost = 20;
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
                nothing.CTCost = 0;
                return nothing;
            }
        }
    }
}
