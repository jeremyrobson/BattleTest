using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BattleTest
{
    class BattleMap : IDrawable
    {
        int width;
        int height;
        BattleTile[,] tiles;

        public BattleMap(int width, int height)
        {
            this.width = width;
            this.height = height;
            tiles = new BattleTile[width, height];

            Random random = new Random();

            for (int x = 0; x < width; x++)
            {
                for (int y = 0; y < height; y++)
                {
                    if (random.Next(0, 3) == 0)
                    {
                        tiles[x,y] = new BattleTile(x, y, "water");
                    }
                    else
                    {
                        tiles[x, y] = new BattleTile(x, y, "grass");
                    }
                }
            }
        }

        public void draw(Graphics g)
        {
            for (int x=0; x<GameBattle.MAP_WIDTH; x++)
            {
                for (int y=0; y<GameBattle.MAP_HEIGHT; y++)
                {
                    tiles[x, y].draw(g);
                }
            }
        }

        public static bool[,] createBinaryMap(int width, int height)
        {
            bool[,] binaryMap = new bool[width, height];
            for (var x=0; x<width; x++)
            {
                for (var y=0; y<height; y++)
                {
                    binaryMap[x,y] = false;
                }
            }
            return binaryMap;
        }

        public static List<MoveNode> getMapNodes(BattleTile[,] tiles, int width, int height, List<BattleUnit> units, BattleUnit unit, int maxSteps, bool filtered = false)
        {
            var binaryMap = createBinaryMap(width, height);
            binaryMap[unit.x, unit.y] = true; //visit starting node

            int i = 0, steps = 0;
            int[] xList = new int[] { 0, -1, 0, 1 };
            int[] yList = new int[] { -1, 0, 1, 0 };
            int min = 0, max = 0;

            List<MoveNode> nodeList = new List<MoveNode>();
            nodeList.Add(new MoveNode(unit.x, unit.y, 0, null));

            while (i < nodeList.Count)
            {
                for (int j = 0; j < 4; j++)
                {
                    int x = nodeList[i].x + xList[j];
                    int y = nodeList[i].y + yList[j];
                    steps = nodeList[i].steps + 1;

                    //if node is off the map
                    if (x < 0 || y < 0 || x >= width || y >= height)
                    {
                        continue; //skip this node
                    }

                    //if node has already been visited
                    if (binaryMap[x,y])
                    {
                        continue; //skip this node
                    }

                    //if node is not grass
                    if (tiles[x,y].type != "grass")
                    {
                        continue; //skip this node
                    }

                    var mapUnit = tiles[x,y].units[0];

                    //filter our enemy units
                    if (filtered)
                    {
                        //if unit exists on node and is enemy
                        if (mapUnit != null && mapUnit.team != unit.team)
                        {
                            //if enemy is not dead
                            if (mapUnit.status != "dead")
                            {
                                continue; //skip this node
                            }
                        }
                    }

                    min = steps < min ? steps : min;
                    max = steps > max ? steps : max;
                    nodeList.Add(new MoveNode(x, y, steps, nodeList[i]));

                    binaryMap[x,y] = true; //visit node
                }
                i++;
            }

            //filter out occupied nodes
            if (filtered)
            {
                //remove occupied mapNodes UNLESS occupied by self
                nodeList = nodeList.Where(node => {
                    if (tiles[node.x,node.y].units.Count > 0)
                    { //if there are units
                        if (tiles[node.x,node.y].units[0].id == unit.id)
                        { //if unit is self
                            return true; //node is valid
                        }
                    }
                    else
                    { //if there are no units
                        return true; //node is valid
                    }
                    return false;
                }).ToList();
            }

            /*
            nodeList.forEach(function(node) {
                node.stepScore = (node.steps - min) / (max - min);
            });
            */

            return nodeList;
        }

        public static List<MoveNode> getPath(MoveNode node)
        {
            List<MoveNode> path = new List<MoveNode>();
            MoveNode current = node;

            while (current != null)
            {
                path.Add(current);
                current = current.parent;
            }

            path.Reverse();

            return path;
        }

        public static bool inRange(int x, int y)
        {
            return x >= 0 && x < GameBattle.MAP_WIDTH && y >= 0 && y < GameBattle.MAP_HEIGHT;
        }
    }
}

