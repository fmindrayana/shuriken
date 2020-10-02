<?php

namespace App\Commands\Shuriken\Export\Hugo;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Post;

class HugoExporter extends Command
{
    public $zip;
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'export:hugo';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Export all posts to hugo. Usage: Unzip export file and put in content/posts folder.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->zip = new \PhpZip\ZipFile();

        $this->task('🍣 Exporting posts to hugo', function(){

            foreach(Post::whereNotNull('content')->cursor() as $post){
                $this->task('🍣 Exporting post: ' . $post->slug . '.md', function() use ($post){
                    $converter = new \Markdownify\Converter;
                    $post->content_markdown = $converter->parseString($post->content);
                    $post->save();

                    $content = blade()->render('export.hugo.post', ['post' => $post]);

                    $this->zip->addFromString($post->slug . '.html', $content);
                });
            }

            $this->zip->saveAsFile(base_path('exports/' . date('Y-m-d') . '/hugo-' . time() . '.zip'));
            $this->zip->close();
        });
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
