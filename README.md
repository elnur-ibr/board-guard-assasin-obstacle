Assassin
--------
Write a method that given a board, `b`, with obstacles, guards, and an assassin, will determine if said assassin can
reach the bottom right undetected:
object Assassin {
def undetected(b: Array[String]): Boolean
}
The "board" is an array of same-size strings where each string is a row on the board and each array element is a
column. The assassin is represented with an `A`. The obstacles on the board are represented with an `X`. And, the guards are represented with `>`, `<`, `^`, or `v` where the pointy part of the guard points to its line of sight: right, left, up, or down, respectively. The assassin cannot cross a guard's line of sight and remain undetected. Also, the assassin cannot cross obstacles, `X`s, or guards. The goal is for the assassin, `A`, to get to the bottom right of the board undetected.
The following are some examples:
1. B: "AX..",
   "....",
   ".X.."
   goal: success
2. B: "AX..",
   "..>.",
   ".X.."
   goal: fail
   reason: the only passageway, y: 1, x: 3, is in plain view of `>`.
   Solve in an efficient manner.