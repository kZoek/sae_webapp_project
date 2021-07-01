<?php
require_once("core/init.php");
// title of the page and meta desc
$pageTitle = 'game';
$metaDesc= 'the actual game';
$cssSep = 'game.css';
// load the html-head and header 
require_once("layouts/header.php");
/**
 * fetchSingle and fetchAll awaits 2 parameters
 * @param $query -> query wich should be executed
 * @param $params -> array, with parameters for prepared statements
 */
$score = $content->fetchAll("SELECT username, score FROM `users` ORDER BY score DESC LIMIT 5 ");
// var_dump($score);
?>

<script src="https://unpkg.com/vue"></script>
<!-- maze game -->
<section id="app">
    <!-- start button for the game -->
<button v-if="!showWinDialog" class="start" @click="initialize"><span>Start Game </span></button>
    <span v-show="debug">Player's Position: {{playerCoordinates}}</span>
<!-- endgame pop-up window -->
    <div v-if="showWinDialog" class="pop-up">    
        <p>Contgrats! Your score is {{score}}</p>
        <button class="next-lvl" @click="initialize">next level</button>
    </div>
<!-- status display  -->
    <aside class="gamestatus">
        <table id="score">
            <tr>
              <th>Time</th>
              <th>Stage</th>
            </tr>
            <tr>
              <td>{{time}}</td>
              <td>{{finishedGames}}</td>
            </tr>
        </table>
    </aside>
    <!-- the game it self -->
        <table id="game" class="game">
            <tr v-for="line in maze">
                <td v-for="cell in line" class="cell" v-bind:class="{'no-top': canGoNorth(cell), 'no-bottom': canGoSouth(cell), 'no-left': canGoWest(cell), 'no-right': canGoEast(cell), 
            'player': (cell.hold === references.player), 'goal': (cell.hold === references.goal), 'player-up': (isFacingNorth()) && (cell.hold === references.player), 
            'player-right': (isFacingWest()) && (cell.hold === references.player), 'player-left': (isFacingEast()) && (cell.hold === references.player), 
            'player-down': (isFacingSouth()) && (cell.hold === references.player)}">
                </td>
            </tr>
        </table>
</section>

<!-- scoreboard -->
<section class="scoreboard">
        <table class="shadow">
           <tr>
               <th class="row-title">Player</th>
               <th class="row-title">Score</th>
           </tr>
        <?php foreach($score as $user) : ?>
           <tr>
               <td><?=escape($user['username'])?></td>
               <td class="score"><?=escape($user['score'])?></td>
           </tr>
        <?php endforeach; ?>
        </table>
    </section>


    <script>
        // create new Vue-object
        const app = new Vue({
            el: '#app',
            // attributes
            data: {
                directions: {
                    N: 0b0001, // 1
                    S: 0b0010, // 2
                    E: 0b0100, // 4
                    W: 0b1000 // 8
                },
                debug: false,
                height: 3,
                width: 3,
                finishedGames: 0,
                steps: 0,
                //statusMessage: '...',
                maze: [],
                time: 0,
                score: 0,
                showWinDialog: false,
                isClockRunning: false,
                points: 0,
                references: {
                    empty: 0,
                    wall: 1,
                    player: 2,
                    goal: 3,
                    border: 9,
                },
                status: {
                    notVisited: 0,
                    visited: 1
                },
                playerCoordinates: {
                    x: 0,
                    y: 0
                },
                movementVector: {
                    x: 0,
                    y: 0
                }
            },
            // on page load method
            mounted: function () {
                window.addEventListener('keydown', function (e) {
                    app.keymonitor(e);
                });

                window.setInterval((function(){
                return function() {
                    if (app.isClockRunning){
                        app.time++;
                    }
                        };
                }()), 1000);

            },
            methods: {
                // movements methods
                keymonitor: function (event) {
                    if(this.isClockRunning) {
                        this.move(event.key);
                    }
                },
                move(dir) {
                    this.steps++;
                    let oldPosition = {
                        x: this.playerCoordinates.x,
                        y: this.playerCoordinates.y
                    };
                    switch (dir.toLowerCase()) {
                        case 'arrowleft':
                        case 'a':
                            this.step(-1, 0)
                            break;
                        case 'arrowright':
                        case 'd':
                            this.step(1, 0)
                            break;
                        case 'arrowup':
                        case 'w':
                            this.step(0, -1)
                            break;
                        case 'arrowdown':
                        case 's':
                            this.step(0, 1)
                            break;
                        default:
                            break;
                    }
                    this.movementVector = {x: oldPosition.x - this.playerCoordinates.x,
                                        y: oldPosition.y - this.playerCoordinates.y }
                    this.updatePosition(oldPosition);
                },
                // check if the player can move or not
                step(x, y) {
                    if (this.canGoSouth(this.maze[this.playerCoordinates.y][this.playerCoordinates.x]) && y ===
                        1) {
                        this.playerCoordinates.y += 1;
                    } else if (this.canGoNorth(this.maze[this.playerCoordinates.y][this.playerCoordinates.x]) &&
                        y === -1) {
                        this.playerCoordinates.y -= 1;
                    } else if (this.canGoWest(this.maze[this.playerCoordinates.y][this.playerCoordinates.x]) &&
                        x === -1) {
                        this.playerCoordinates.x -= 1;
                       
                    } else if (this.canGoEast(this.maze[this.playerCoordinates.y][this.playerCoordinates.x]) &&
                        x === 1) {
                        this.playerCoordinates.x += 1;
                     
                    }
                },
                 // clears last cell, who the player was, if the player goes to goal game ends 
                 updatePosition(oldPosition) {
                    if (oldPosition.y === this.playerCoordinates.y && oldPosition.x === this.playerCoordinates
                        .x) {
                       // this.statusMessage = 'Sorry, not possible.';
                        return;
                    }
                    //this.statusMessage = 'You moved.';
                    this.maze[oldPosition.y][oldPosition.x].hold = this.references.empty;
                    
                    if (this.maze[this.playerCoordinates.y][this.playerCoordinates.x].hold === this.references.goal) {
                        this.finishGame();
                    } else {
                        this.maze[this.playerCoordinates.y][this.playerCoordinates.x].hold = this.references.player;
                    }
                },
                // change player img to facing directions
                isFacingNorth() {
                    if(this.movementVector.y === 1) {
                        return true;
                    }
                    return false;
                },
                isFacingSouth() {
                    if(this.movementVector.y === -1) {
                        return true;
                    }
                    return false;
                },
                isFacingWest() {
                    if(this.movementVector.x === -1) {
                        return true;
                    }
                    return false;
                },
                isFacingEast() {
                    if(this.movementVector.x === 1) {
                        return true;
                    }
                    return false;
                },
                // end game method
                finishGame() {
                    this.score = this.calculateScore();
                    this.isClockRunning = false;
                    this.finishedGames++;
                    if (this.finishedGames % 3 === 0) {
                        this.width++;
                        this.height++;
                    }
                    this.addScorestoDB(this.score);
                    this.showWinDialog = true;
                },
                // calculate score
                calculateScore() {
                    let score = (this.width * this.height) - this.time - this.steps;
                    // console.log(score);
                    return Math.max(score, 0);
                },
                // add calculated score to db if user is logged in
                addScorestoDB(score){
                    if (score === 0) return;
                    $.ajax({
                        type:'POST',
                        url:'includes/update_score.php',
                        data: {score: score},
                        success: function(result){
                            console.log(result);
                        }
                    })
                },
                // game start method - the maze will be structured, player and goal positioned
                initialize() {
                    this.playerCoordinates = {
                        x: 0,
                        y: 0
                    };
                    this.showWinDialog = false;
                    this.steps = 0;
                    this.time = 0;
                    this.maze = Array(this.width).fill(null).map(() => Array(this.height).fill(0));
                    this.buildMaze();
                    this.maze[this.width - 1][this.height - 1].hold = this.references.goal;
                    this.maze[0][0].hold = this.references.player;
                },
                // set a starter point for the algorithm
                buildMaze() {
                    this.prepareMazeStructure();
                    let startingPoint = {
                        x: 1,
                        y: 1
                    };

                    this.carvePassage(startingPoint.x, startingPoint.y);
                    this.isClockRunning = true;
                },
                // creates for each cell an object
                prepareMazeStructure() {
                    this.maze.forEach((m, y) => {
                        m.forEach((cell, x) => {
                            m[x] = {
                                type: this.references.empty,
                                status: this.status.notVisited,
                                x: x,
                                y: y,
                                hold: this.references.empty
                            };
                        })
                    })
                },
                /** Recursive Backtracking algorithm
                 *  select a cell, break a random wall, if the cell is not visited and tag the cell as visited.
                 *  If no cells are available, step back - start again
                 *  and when all cells are visited 
                 *  */ 
                carvePassage(x, y) {

                    if (this.maze[y][x].status === this.status.visited) {
                        return;
                    }

                    this.maze[y][x].status = this.status.visited;

                    let notVisitedCells = this.getAdjecentCells(x, y);

                    while (notVisitedCells.length != 0) {
                        let notVisitedCell = notVisitedCells[Math.floor((Math.random() * notVisitedCells
                            .length))]
                        notVisitedCells = notVisitedCells.filter(x => x != notVisitedCell);
                        if (notVisitedCell.status == this.status.visited) {
                            continue;
                        }
                        let movement = {
                            x: notVisitedCell.x - x,
                            y: notVisitedCell.y - y
                        };

                        if (movement.y === 1) {
                            this.maze[y][x].type |= this.directions.S;
                            notVisitedCell.type |= this.directions.N;
                        } else if (movement.y === -1) {
                            this.maze[y][x].type |= this.directions.N;
                            notVisitedCell.type |= this.directions.S;
                        } else if (movement.x === 1) {
                            this.maze[y][x].type |= this.directions.E;
                            notVisitedCell.type |= this.directions.W;
                        } else if (movement.x === -1) {
                            this.maze[y][x].type |= this.directions.W;
                            notVisitedCell.type |= this.directions.E;
                        }

                        let destiny = {
                            x: x + movement.x,
                            y: y + movement.y
                        }

                        this.carvePassage(notVisitedCell.x, notVisitedCell.y);

                    }

                },
                // check if the cell got an adjecent cells and return these.
                getAdjecentCells(x, y) {
                    let adjecentWalls = [];
                    const step = 1;

                    if (this.maze[y + step] && this.maze[y + step][x] && this.maze[y + step][x].status == this
                        .status.notVisited) {
                        adjecentWalls.push(this.maze[y + step][x]);
                    }
                    if (this.maze[y - step] && this.maze[y - step][x] && this.maze[y - step][x].status == this
                        .status.notVisited) {
                        adjecentWalls.push(this.maze[y - step][x]);
                    }
                    if (this.maze[y] && this.maze[y][x + step] && this.maze[y][x + step].status == this.status
                        .notVisited) {
                        adjecentWalls.push(this.maze[y][x + step]);
                    }
                    if (this.maze[y] && this.maze[y][x - step] && this.maze[y][x - step].status == this.status
                        .notVisited) {
                        adjecentWalls.push(this.maze[y][x - step]);
                    }

                    return adjecentWalls;
                },
                // checks if the cell is accessible
                canGoNorth(cell) {
                    return (cell.type & this.directions.N) > 0;
                },
                canGoSouth(cell) {
                    return (cell.type & this.directions.S) > 0;
                },
                canGoWest(cell) {
                    return (cell.type & this.directions.W) > 0;
                },
                canGoEast(cell) {
                    return (cell.type & this.directions.E) > 0;
                }
            }
        })
    </script>
<?php
// load the footer and html end
require_once("layouts/footer.php");
?>