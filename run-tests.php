<?php

/**
 * SimPDF Library - Test Runner
 * 
 * This script runs all the important tests for SimPDF library
 */

echo "🧪 SimPDF Library - Test Runner\n";
echo "===============================\n\n";

$tests = [
    'Basic Test' => 'tests/basic-test.php',
    'Advanced Test' => 'tests/advanced-test.php', 
    'Comprehensive Test' => 'tests/comprehensive-test.php'
];

$passed = 0;
$total = count($tests);

foreach ($tests as $name => $file) {
    echo "Running {$name}...\n";
    echo str_repeat('-', 50) . "\n";
    
    if (file_exists($file)) {
        $output = [];
        $returnCode = 0;
        
        exec("php {$file} 2>&1", $output, $returnCode);
        
        if ($returnCode === 0) {
            echo "✅ {$name}: PASSED\n";
            $passed++;
        } else {
            echo "❌ {$name}: FAILED\n";
            echo "Output: " . implode("\n", $output) . "\n";
        }
    } else {
        echo "❌ {$name}: FILE NOT FOUND\n";
    }
    
    echo "\n";
}

echo "📊 Test Results Summary\n";
echo "=======================\n";
echo "Passed: {$passed}/{$total}\n";
echo "Failed: " . ($total - $passed) . "/{$total}\n";

if ($passed === $total) {
    echo "\n🎉 All tests passed! SimPDF library is working correctly.\n";
} else {
    echo "\n⚠️  Some tests failed. Please check the output above.\n";
}

echo "\n📚 For more information, visit: https://github.com/5u00n/sim-pdf-libs\n";
