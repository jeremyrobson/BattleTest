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
        Graphics g;
        BufferedGraphics bg;
        BufferedGraphicsContext bgc;

        Timer timer;
        GameBattle battle;

        public Form1()
        {
            InitializeComponent();

            bgc = BufferedGraphicsManager.Current;
            bg = bgc.Allocate(pictureBox1.CreateGraphics(), pictureBox1.DisplayRectangle);
            battle = new GameBattle(bg);

            timer = new Timer();
            timer.Tick += new EventHandler(loop);
            timer.Interval = 500;
            timer.Enabled = true;
        }

        public void loop(object source, EventArgs e)
        {
            battle.update();
            textQueue.Text = battle.ToString();

            textConsole.AppendText(GameBattle.getConsoleBuffer());
        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }
    }



}
