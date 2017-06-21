using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    public interface IQueueable : IComparable<IQueueable>, IDrawable
    {
        bool Remove { get; set; }
        bool Ready { get; set; }
        bool Done { get; set; }
        int ID { get; set; }
        int Priority { get; set; }
        int CTR { get; set; }
        int CT { get; set; }
        int Speed { get; set; }
        void tick();
        void invoke(BattleMap map, List<BattleUnit> units, BattleQueue queue);
    }
}
