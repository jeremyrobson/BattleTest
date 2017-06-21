using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    public class BattleTile : ITargetable, IDrawable
    {
        public int X { get; set; }
        public int Y { get; set; }
        public string type;
        public string sprite;
        Color color;
        public List<BattleUnit> units;
        Brush brush;

        public BattleTile(int x, int y, string type)
        {
            this.X = x;
            this.Y = y;
            this.type = type;
            units = new List<BattleUnit>();

            if (type == "grass")
            {
                brush = Brushes.DarkOliveGreen;
            }
            else
            {
                brush = Brushes.AliceBlue;
            }
        }

        public void addUnit(BattleUnit unit)
        {
            units.Add(unit);
        }

        public void removeUnit(BattleUnit unit)
        {
            units.Remove(unit);
        }

        public BattleUnit getFirstUnit()
        {
            return units.FirstOrDefault();
        }

        public List<BattleUnit> getUnits()
        {
            return units;
        }

        public void draw(Graphics g)
        {
            g.FillRectangle(
                brush,
                X * GameBattle.TILE_WIDTH,
                Y * GameBattle.TILE_HEIGHT,
                GameBattle.TILE_WIDTH,
                GameBattle.TILE_HEIGHT);
        }
    }
}
