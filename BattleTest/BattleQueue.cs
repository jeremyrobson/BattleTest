using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

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

            list.ForEach(item => item.tick());

            if (list[0].Ready)
            {
                return list[0];
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
            /*
            this.list.forEach(function(item) {
                if (item instanceof BattleAction) {
                    item.spread.forEach(function(s) {
                        ctx.fillStyle = "rgba(255, 0, 255, 1.0)";
                        ctx.fillRect(s.x * TILE_WIDTH, s.y * TILE_HEIGHT, TILE_WIDTH - 1, TILE_HEIGHT - 1);
                        ctx.fillStyle = "rgba(255,255,255,1.0)";
                        ctx.font = "16px Arial";
                        ctx.fillText(item.ctr, s.x * TILE_WIDTH + 16, s.y * TILE_WIDTH + 16);
                    });
                }
            });
            */
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

    }
}
