using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class MoveNode
    {
        public int x, y, steps;
        public MoveNode parent;
        public double safetyScore, stepScore;
        Brush brush;

        public MoveNode(int x, int y, int steps, MoveNode parent)
        {
            this.x = x;
            this.y = y;
            this.steps = steps;
            this.parent = parent;
            safetyScore = 0;
            stepScore = 0;
            brush = new SolidBrush(Color.FromArgb(127, 0, 0, 255));
        }

        public bool equals(int x, int y)
        {
            return this.x == x && this.y == y;
        }

        public void draw(Graphics g)
        {
            g.FillRectangle(brush, x * GameBattle.TILE_WIDTH, y * GameBattle.TILE_HEIGHT, GameBattle.TILE_WIDTH, GameBattle.TILE_HEIGHT);
        }

        public void recursiveDraw(Graphics g)
        {
            MoveNode node = this;
            while (node != null)
            {
                node.draw(g);
                node = node.parent;
            }
        }

        public override string ToString()
        {
            return "( " + this.x + ", " + this.y + ")";
        }
    }
}