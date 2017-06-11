using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;

namespace BattleTest
{
    class BattleMap : IDrawable
    {
        int width;
        int height;
        public BattleTile[,] tiles;

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
                    //if (random.Next(0, 3) == 0)
                    //{
                        //tiles[x,y] = new BattleTile(x, y, "water");
                    //}
                    //else
                    //{
                        tiles[x, y] = new BattleTile(x, y, "grass");
                    //}
                }
            }
        }

        public void addUnits(List<BattleUnit> units)
        {
            units.ForEach(unit => this.tiles[unit.x, unit.y].addUnit(unit));
        }

        public void moveUnit(ref BattleUnit unit, int x, int y)
        {
            tiles[unit.x,unit.y].removeUnit(unit);
            unit.x = x;
            unit.y = y;
            tiles[x,y].addUnit(unit);

            if (tiles[x,y].units.Count > 1)
            {
                throw new Exception("error: units overlapped");
            }
        }

        public List<BattleUnit> getTileUnits(int x, int y)
        {
            return tiles[x, y].units;
        }

        public BattleUnit getFirstTileUnit(int x, int y)
        {
            return tiles[x, y].getFirstUnit();
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

        public static double getTileSafetyScore(List<BattleUnit> units, BattleUnit unit, int x, int y)
        {
            double safetyScore = 0;

            foreach (BattleUnit u in units)
            {
                if (u.Equals(unit))
                {
                    continue;
                }

                int dx = x - u.x;
                int dy = y - u.y;
                double distance = Math.Sqrt(dx * dx + dy * dy);
                if (u.team == unit.team)
                { //distance from ally
                    safetyScore += (distance == 0) ? 1 : (1 / distance);
                }
                else
                { //distance from enemy
                    safetyScore -= (distance == 0) ? 1 : (1 / distance);
                }
            }

            //check queue for future action spreads that hit this tile
            List<BattleAction> actions = GameBattle.queue.getActions(x, y, 20); //find all actions under 20 ctr
            actions.ForEach(action => {
                // "what if" the unit moved to the proposed x,y?
                int damage = BattleAction.getDamage(action.actor, unit, action.actiondef);
                if (damage > 0)
                { //unit would be damaged
                    safetyScore -= 1;
                }
                if (unit.hp - damage < 0)
                { //unit would be killed
                    safetyScore -= 2;
                }
                if (damage < 0)
                { //unit would be healed
                    safetyScore += 1;
                }

            });

            return safetyScore;
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

        public static List<MoveNode> getMoveNodes(BattleTile[,] tiles, int width, int height, List<BattleUnit> units, BattleUnit unit, int maxSteps, bool filtered = false)
        {
            var binaryMap = createBinaryMap(width, height);
            binaryMap[unit.x, unit.y] = true; //visit starting node

            int i = 0, steps = 0;
            int[] xList = new int[] { 0, -1, 0, 1 };
            int[] yList = new int[] { -1, 0, 1, 0 };
            int min = 0, max = 0;

            double initialSafetyScore = getTileSafetyScore(units, unit, unit.x, unit.y);
            double minSafetyScore = initialSafetyScore;
            double maxSafetyScore = initialSafetyScore;

            List<MoveNode> nodeList = new List<MoveNode>();
            nodeList.Add(new MoveNode(unit.x, unit.y, 0, null, initialSafetyScore));

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

                    var mapUnit = tiles[x, y].getFirstUnit();

                    //filter out enemy units
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

                    double safetyScore = getTileSafetyScore(units, unit, x, y);
                    minSafetyScore = safetyScore < minSafetyScore ? safetyScore : minSafetyScore;
                    maxSafetyScore = safetyScore > maxSafetyScore ? safetyScore : maxSafetyScore;

                    //min = steps < min ? steps : min;
                    //max = steps > max ? steps : max;
                    nodeList.Add(new MoveNode(x, y, steps, nodeList[i], safetyScore));

                    binaryMap[x,y] = true; //visit node
                }
                i++;
            }

            //filter out occupied nodes
            if (filtered)
            {
                //remove occupied mapNodes UNLESS occupied by self
                nodeList = nodeList.Where(node => {
                    if (tiles[node.x,node.y].units.Count > 0) //if there are units
                    {
                        if (tiles[node.x,node.y].units[0].Equals(unit)) //if unit is self
                        {
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

            //normalize safety scores
            nodeList.ForEach(node => {
                node.SafetyScore = (node.SafetyScore - minSafetyScore) / (maxSafetyScore - minSafetyScore);
            });

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

