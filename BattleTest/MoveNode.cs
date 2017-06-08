using System;
using System.Collections.Generic;
using System.Drawing;
namespace BattleTest
{
    class MoveNode : IComparable<MoveNode>
    {
        public int x, y, steps;
        public MoveNode parent;
        double safetyScore, stepScore;
        Pen pen = new Pen(new SolidBrush(Color.FromArgb(255, 0, 0, 100)));
        List<Brush> brushes;
        Brush moveBrush;
        Brush pathBrush;
        Rectangle rect;

        public double SafetyScore
        {
            get
            {
                return safetyScore;
            }
            set
            {
                safetyScore = value;
                int r = (int)(safetyScore * 255);
                if (r < 0)
                {
                    r = 0;
                }
                moveBrush = new SolidBrush(Color.FromArgb(200, r, 0, 255-r));
            }
        }

        public MoveNode(int x, int y, int steps, MoveNode parent, double safetyScore = 0)
        {
            this.x = x;
            this.y = y;
            this.steps = steps;
            this.parent = parent;
            this.safetyScore = safetyScore;
            stepScore = 0;
            moveBrush = new SolidBrush(Color.FromArgb(200, 0, 0, 255));
            pathBrush = new SolidBrush(Color.FromArgb(200, 0, 255, 255));
            rect = new Rectangle(x * GameBattle.TILE_WIDTH, y* GameBattle.TILE_HEIGHT, GameBattle.TILE_WIDTH, GameBattle.TILE_HEIGHT);

            //gradient from red to yellow to green
            brushes = new List<Brush>();
            brushes.Add(new SolidBrush(Color.FromArgb(255, 255, 0, 55)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 255, 0, 100)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 255, 0, 155)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 255, 0, 200)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 255, 0, 255)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 200, 0, 255)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 155, 0, 255)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 100, 0, 255)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 55, 0, 255)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 0, 0, 255)));
            brushes.Add(new SolidBrush(Color.FromArgb(255, 0, 0, 255)));
        }

        public bool equals(int x, int y)
        {
            return this.x == x && this.y == y;
        }

        public void draw(Graphics g)
        {
            moveBrush = brushes[(int)(safetyScore * 10)];
            g.FillRectangle(moveBrush, rect);
            g.DrawRectangle(pen, rect);
        }

        public void recursiveDraw(Graphics g)
        {
            MoveNode node = this;
            while (node != null)
            {
                g.FillRectangle(pathBrush, node.rect);
                g.DrawRectangle(pen, node.rect);
                node = node.parent;
            }
        }

        //sort descending
        public int CompareTo(MoveNode node)
        {
            if (safetyScore < node.safetyScore) return 1;
            if (safetyScore > node.safetyScore) return -1;
            return 0; //this should never happen
        }

        public override string ToString()
        {
            return "( " + this.x + ", " + this.y + ")";
        }
    }
}