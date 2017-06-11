var brushes = [
    "rgb(255,0,55)", //red is unsafe
    "rgb(255,0,100)",
    "rgb(255,0,155)",
    "rgb(255,0,200)",
    "rgb(255,0,255)",
    "rgb(200,0,255)",
    "rgb(155,0,255)",
    "rgb(100,0,255)",
    "rgb(55,0,255)",
    "rgb(0,0,255)",
    "rgb(0,0,255)", //blue is safe
];

function createDiamond(x, y, range, includeCenter) {
    var diamond = [];
    for (var i=-range; i<=range; i++) {
        for (var j=-range; j<=range; j++) {
            if (!includeCenter && i == 0 && j == 0) {
                continue;
            }
            else if (Math.abs(i) + Math.abs(j) <= range) {
                diamond.push({
                    x: i + x,
                    y: j + y
                });
            }
        }
    }
    return diamond;
}

function getTileSafetyScore(tiles, units, unit, x, y) {
    var safetyScore = 0;

    units.forEach(function(u) {
        if (unit.team === u.team) {
            return;
        }

        var dx = x - u.x;
        var dy = y - u.y;
        var distance = Math.sqrt(dx*dx + dy*dy);
        if (distance === 0) { //distance from self
            safetyScore += 0;
        }
        else if (u.team === unit.team) { //distance from ally
            safetyScore += (1 / distance);
        }
        else { //distance from enemy
            safetyScore -= (1 / distance);
        }
    });

    //check queue for future action spreads that hit this tile
    /*
    var actions = battle.queue.getActions(x, y, 20);
    actions.forEach(function(action) {
        // "what if" the unit moved to the proposed x,y?
        var damage = action.getDamage(unit);
        if (damage > 0) { //unit would be damaged
            safetyScore -= 1;
        }
        if (unit.hp - damage < 0) { //unit would be killed
            safetyScore -= 2;
        }
        if (damage < 0) { //unit would be healed
            safetyScore += 1;
        }
        
    });
    */

    return safetyScore;
}

function createBinaryMap(tiles, width, height) {
    var bmap = [];
    for (var x=0; x<width; x++) {
        bmap[x] = [];
        for (var y=0; y<height; y++) {
            bmap[x][y] = 0;
        }
    }
    return bmap;
}

function create_movenode(x, y, steps, parent, safetyScore) {
    return {
        x: x,
        y: y,
        steps: steps,
        parent: parent,
        safetyScore: safetyScore
    };
}

function getMoveNodes(tiles, units, unit, maxSteps, filtered = false) {
    var binaryMap = createBinaryMap(tiles, MAP_WIDTH, MAP_HEIGHT);
    binaryMap[unit.x][unit.y] = 1; //visit starting node

    var i = 0, steps = 0;
    var xList = [0, -1, 0, 1];
    var yList = [-1, 0, 1, 0];
    var minSafetyScore = 0, maxSafetyScore = 0;

    var nodeList = [];
    var initialSafetyScore = getTileSafetyScore(tiles, units, unit, unit.x, unit.y);
    nodeList.push(create_movenode(unit.x, unit.y, 0, null, initialSafetyScore));
    var minSafetyScore = initialSafetyScore;
    var maxSafetyScore = initialSafetyScore;

    while (i < nodeList.length) {
        for (var j=0; j<4; j++) {

            var x = nodeList[i].x + xList[j];
            var y = nodeList[i].y + yList[j];
            steps = nodeList[i].steps + 1;

            //if node is off the map
            if (x < 0 || y < 0 || x >= MAP_WIDTH || y >= MAP_HEIGHT) {
                continue; //skip this node
            }

            //if node has already been visited
            if (binaryMap[x][y] === 1) {
                continue; //skip this node
            }

            if (tiles[x][y].type != "grass") {
                continue; //skip this node
            }

            var mapUnit = tiles[x][y].units[0];

            //filter out enemy units
            if (filtered) {
                //if unit exists on node and is enemy
                if (mapUnit && mapUnit.team !== unit.team) {
                    //if enemy is not dead
                    if (mapUnit.status !== "dead") {
                        continue; //skip this node
                    }
                }
            }

            var safetyScore = getTileSafetyScore(tiles, units, unit, x, y);
            minSafetyScore = safetyScore < minSafetyScore ? safetyScore : minSafetyScore;
            maxSafetyScore = safetyScore > maxSafetyScore ? safetyScore : maxSafetyScore;

            nodeList.push(create_movenode(x, y, steps, nodeList[i], safetyScore));

            binaryMap[x][y] = 1; //visit node
        }
        i++;
    }

    //remove occupied mapNodes
    if (filtered) {
        //remove occupied mapNodes UNLESS occupied by self
        nodeList = nodeList.filter(function(node) {
            return tiles[node.x][node.y].units.length === 0 || tiles[node.x][node.y].units[0].id === unit.id;
        });
    }

    //normalize safety scores between 0 and 1
    nodeList.forEach(function(node) {
        node.safetyScore = (node.safetyScore - minSafetyScore) / (maxSafetyScore - minSafetyScore);
    });

    return nodeList;
}