using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;

namespace BattleTest
{
    public class BattleQueue
    {
        List<IQueueable> list;

        public BattleQueue(List<BattleUnit> units)
        {
            list = new List<IQueueable>();
            list.AddRange(units);
        }

        public void update()
        {
            if (!list[0].Ready || list[0].Done)
            {
                tick();
            }
        }

        public void tick()
        {
            //filter items where Remove is true
            list = list.Where(item => !item.Remove).ToList();

            sort();

            list.ForEach(item => item.tick());
        }

        public IQueueable getActiveItem()
        {
            if (list[0].Ready)
            {
                return list[0];
            }
            else
            {
                return null;
            }
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
            return list.OfType<BattleAction>().Where(action => action.CTR <= ctr && GameBattle.listHasPoint(action.Spread, x, y)).ToList();
        }

        public static int getTargetFutureDamage(BattleUnit unit, BattleUnit target, int CTR)
        {
            /*
             * This function calculates the amount of damage to be inflicted upon a unit from actions
             * targetted at that unit's x,y location before a given CTR value
             */
            BattleQueue queue = GameBattle.getQueue();
            int damage = 0;
            List<BattleAction> actions = queue.getActions(target.X, target.Y, CTR);

            actions.ForEach(action => damage += BattleAction.getDamage(unit, target, action.actiondef));
            return damage;
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
