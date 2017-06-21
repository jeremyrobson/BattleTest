using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace BattleTest
{
    public sealed class GameBattle
    {
        public const int MAP_WIDTH = 16;
        public const int MAP_HEIGHT = 16;
        public const int TILE_WIDTH = 32;
        public const int TILE_HEIGHT = 32;

        static Timer timer;

        public static volatile GameBattle instance;
        public BattleQueue queue;
        BattleMap map;
        List<BattleUnit> units;
        IQueueable activeItem;
        public static string consoleBuffer { get; set; }
        public static int consoleCount;

        public GameBattle()
        {
            map = new BattleMap(MAP_WIDTH, MAP_HEIGHT);

            units = new List<BattleUnit>();
            units.Add(new BattleUnit("alfred","cpu1",0,0));
            units.Add(new BattleUnit("bob", "cpu2", 2, 2));

            map.addUnits(units);

            queue = new BattleQueue(units);

            consoleBuffer = "";
        }

        public static void start()
        {
            instance = new GameBattle();
            timer = new Timer(_ => instance.update(), null, 0, 1000);
        }

        public static int generateID()
        {
            return Guid.NewGuid().GetHashCode();
        }

        public void update()
        {
            activeItem = queue.getActiveItem();
            
            if (activeItem != null)
            {
                activeItem.invoke(map, units, queue);
            }

            queue.update();
        }

        public static bool listHasPoint(List<Point> list, int x, int y)
        {
            return list.Any(item => item.X == x && item.Y == y);
        }

        public static void WriteLine(string line)
        {
            consoleCount++;
            consoleBuffer += consoleCount + ". " + line + "\r\n";
        }

        public static string getConsoleBuffer()
        {
            string text = consoleBuffer;
            consoleBuffer = "";
            return text;
        }

        public static BattleQueue getQueue()
        {
            return instance.queue;
        }

        public static BattleMap getMap()
        {
            return instance.map;
        }

        public static BattleUnit getActiveUnit()
        {
            BattleUnit unit = null;

            IQueueable activeItem = instance.queue.getActiveItem();
            if (activeItem != null)
            {
                if (activeItem.GetType() == typeof(BattleUnit))
                {
                    unit = (BattleUnit)activeItem;
                }
            }

            return unit;
        }

        public static List<BattleUnit> getUnits()
        {
            return instance.units;
        }

        public static BattleTile[,] getTiles()
        {
            return instance.map.tiles;
        }

        public static List<MoveNode> getMoveNodes()
        {
            BattleUnit unit = getActiveUnit();

            if (unit != null && unit.action != null && unit.action.moveNodes != null)
            {
                return unit.action.moveNodes;
            }
            else
            {
                return null;
            }
        }
    }
}
