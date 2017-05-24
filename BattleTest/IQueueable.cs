using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    interface IQueueable : IComparable<IQueueable>
    {
        bool Remove { get; set; }
        bool Ready { get; set; }
        int Priority { get; set; }
        int CTR { get; set; }
        int CT { get; set; }
        void tick();
        void invoke(BattleTile[,] tiles);
    }
}
