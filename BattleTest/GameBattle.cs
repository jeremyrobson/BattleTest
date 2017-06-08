﻿using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class GameBattle
    {
        public const int MAP_WIDTH = 16;
        public const int MAP_HEIGHT = 16;
        public const int TILE_WIDTH = 32;
        public const int TILE_HEIGHT = 32;

        BufferedGraphics bg;
        public static BattleQueue queue;
        BattleMap map;
        List<BattleUnit> units;
        IQueueable activeItem;
        public static string consoleBuffer { get; set; }
        public static int consoleCount;

        //public static List<MoveNode> mapNodes;
        //public static BattleMove battleMove;
        //public static BattleAction battleAction;

        public GameBattle(BufferedGraphics bg)
        {
            this.bg = bg;

            map = new BattleMap(MAP_WIDTH, MAP_HEIGHT);

            units = new List<BattleUnit>();
            units.Add(new BattleUnit("alfred","cpu1",0,0));
            units.Add(new BattleUnit("bob", "cpu2", 2, 2));

            map.addUnits(units);

            queue = new BattleQueue(units);

            consoleBuffer = "";
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

            draw();
        }

        public void draw()
        {
            map.draw(bg.Graphics);

            /*
            if (mapNodes != null)
            {
                mapNodes.ForEach(node => node.draw(bg.Graphics));
            }

            if (battleMove != null)
            {
                battleMove.draw(bg.Graphics);
            }

            if (battleAction != null)
            {
                battleAction.draw(bg.Graphics);
            }
            */

            queue.draw(bg.Graphics);

            units.ForEach(unit => unit.draw(bg.Graphics));

            bg.Render();
        }

        public static bool listHasPoint(List<Point> list, int x, int y)
        {
            return list.Any(item => item.X == x && item.Y == y);
        }

        public override string ToString()
        {
            return queue.ToString();
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
    }
}
