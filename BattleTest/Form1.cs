using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace BattleTest
{
    public partial class Form1 : Form
    {
        BufferedGraphics bg;
        BufferedGraphicsContext bgc;

        Timer timer;

        List<BattleUnit> units;
        BattleUnit activeUnit;
        BattleTile[,] tiles;

        public Form1()
        {
            InitializeComponent();

            bgc = BufferedGraphicsManager.Current;
            bg = bgc.Allocate(pictureBox1.CreateGraphics(), pictureBox1.DisplayRectangle);

            GameBattle.start();

            timer = new Timer();
            timer.Tick += new EventHandler(loop);
            timer.Interval = 100;
            timer.Enabled = true;
        }

        public void loop(object source, EventArgs e)
        {
            tiles = GameBattle.getTiles();
            activeUnit = GameBattle.getActiveUnit();
            units = GameBattle.getUnits();

            draw();

            textQueue.Text = GameBattle.getQueue();
            textConsole.AppendText(GameBattle.getConsoleBuffer());
        }

        public void draw()
        {
            if (tiles != null)
            {
                for (int x=0; x<GameBattle.MAP_WIDTH; x++)
                {
                    for (int y=0; y<GameBattle.MAP_HEIGHT; y++)
                    {
                        tiles[x, y].draw(bg.Graphics);
                    }
                }
            }

            if (activeUnit != null)
            {
                if (activeUnit != null && activeUnit.move != null)
                {
                    activeUnit.move.moveNodes.ForEach(node => node.draw(bg.Graphics));
                }

                if (activeUnit.action != null)
                {
                    activeUnit.action.draw(bg.Graphics);
                }
            }

            if (units != null)
            {
                units.ForEach(unit => unit.draw(bg.Graphics));
            }

            bg.Render();
        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }
    }



}
