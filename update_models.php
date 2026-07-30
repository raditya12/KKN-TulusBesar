<?php
$models = glob(__DIR__ . '/app/Models/*.php');
foreach($models as $model) {
    if (basename($model) === 'User.php') continue;
    $content = file_get_contents($model);
    if (strpos($content, 'protected $guarded') === false && strpos($content, 'protected $fillable') === false) {
        $content = str_replace('use HasFactory;', "use HasFactory;\n    protected \$guarded = [];\n", $content);
        file_put_contents($model, $content);
        echo "Updated " . basename($model) . "\n";
    }
}
?>
