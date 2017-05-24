using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class JobClass
    {
        public static JobClass squire;

        public string name;
        public List<ActionDefinition> actions;

        public JobClass singleton()
        {
            squire = new JobClass();
            squire.name = "Squire";
            squire.actions = new List<ActionDefinition>();
            squire.actions.Add(ActionDefinition.singleton());
            return squire;
        }
    }
}
