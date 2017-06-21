using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    public class JobClass
    {
        public string name;
        public List<ActionDefinition> actions;

        public static JobClass squire
        {
            get
            {
                JobClass squire = new JobClass();
                squire.name = "Squire";
                squire.actions = new List<ActionDefinition>();
                squire.actions.Add(ActionDefinition.melee);
                return squire;
            }
        }
    }
}
