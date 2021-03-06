<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DB;
use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Topic $topic)
    {
        // SerializesModels trait，Eloquent 模型会被优雅的序列化和反序列化。
        // 队列任务构造器中接收了 Eloquent 模型, 将会只序列化模型的 ID
        // 这样子在任务执行时，队列系统会从数据库中自动的根据 ID 检索出模型实例
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 请求百度 API 接口进行翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);

        // 为了避免模型监控器死循环调用， 使用 DB 类直接对数据库进行操作
        DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}
