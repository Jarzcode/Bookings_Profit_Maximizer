<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Service;

use SplPriorityQueue;

/**
 * Finds the path with the highest profit in a graph.
 *
 * I have based this implementation on Dijkstra's algorithm but with the inverse way. The Dijkstra's algorithm
 * is used to find the shortest path in a graph, but in this case, we want to find the path with the highest profit.
 */
final class HighestProfitGraphPathFinder
{
    public function invoke(array $graph): array
    {
        $dist = []; // Max profit for each node
        $prev = []; // To reconstruct the best booking path
        $priorityQueue = new SplPriorityQueue(); // Max heap for Dijkstra

        // Initialize distances (profit from each booking to itself)
        foreach ($graph as $node => $edges) {
            $dist[$node] = $edges[$node] ?? 0; // Start with its own profit
            $prev[$node] = null; // No parent initially
            $priorityQueue->insert($node, $dist[$node]);
        }

        // Process nodes from the priority queue
        while (!$priorityQueue->isEmpty()) {
            $u = $priorityQueue->extract(); // Get the node with max profit

            // Relax all neighbors
            foreach ($graph[$u] as $v => $profit) {
                if ($v === $u) {
                    continue; // Skip self-references
                }

                // If choosing `v` increases the profit, update it
                if ($dist[$u] + $profit > ($dist[$v] ?? 0)) {
                    $dist[$v] = $dist[$u] + $profit;
                    $prev[$v] = $u;
                    $priorityQueue->insert($v, $dist[$v]);
                }
            }
        }

        // Find the node with max profit
        $maxProfit = max($dist);
        $maxNode = array_search($maxProfit, $dist);

        // Backtrack to reconstruct the best path
        $bestPath = [];
        while ($maxNode !== null) {
            $bestPath[] = $maxNode;
            $maxNode = $prev[$maxNode];
        }

        return [array_reverse($bestPath), $maxProfit];
    }
}
