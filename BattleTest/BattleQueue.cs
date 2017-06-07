using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;

namespace BattleTest
{
    class BattleQueue
    {
        List<IQueueable> list;

        public BattleQueue(List<BattleUnit> units)
        {
            list = new List<IQueueable>();
            list.AddRange(units);
        }

        public IQueueable tick()
        {
            //filter items where Remove is true
            list = list.Where(item => !item.Remove).ToList();

            sort();

            if (list[0].Ready)
            {
                return list[0];
            }
            else
            {
                list.ForEach(item => item.tick());

                if (list[0].Ready)
                {
                    return list[0];
                }
            }

            return null;
        }

        public void add(IQueueable item)
        {
            list.Add(item);
            sort();
        }

        public void sort()
        {
            list.Sort();
        }

        public void draw(Graphics g)
        {
            list.ForEach(item => {
                if (item.GetType() == typeof(BattleMove))
                {
                    item.draw(g);
                }
                if (item.GetType() == typeof(BattleAction)) {
                    item.draw(g);
                }
            });
        }

        public List<BattleAction> getActions(int x, int y, int ctr)
        {
            return list.OfType<BattleAction>().Where(action => action.CTR <= ctr && GameBattle.listHasPoint(action.spread, x, y)).ToList();
        }

        public override string ToString()
        {
            var outputText = "";
            list.ForEach(item => outputText += item.ToString() + "\r\n");
            return outputText;
        }

        public static int calculateCTR(int CT, int speed)
        {
            return (int) Math.Ceiling((double)CT / speed);
        }
    }
}
