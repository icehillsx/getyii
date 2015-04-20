<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/20 下午9:56
 * description:
 */

use yii\helpers\Html;
use yii\helpers\Markdown;

$index += +1;
?>
<?php if (!$model->status): ?>
    <div class="deleted text-center"><?= $index ?>楼 已删除.</div>
<?php else: ?>
    <div class="avatar pull-left">
        <?php $img = "http://gravatar.com/avatar/" . md5($model->user['email']) . "?s=48"; ?>
        <?= Html::a(Html::img($img, ['class' => 'media-object avatar-48']),
            ['/user/default/show', 'username' => $model->user['username']]
        ); ?>
    </div>

    <div class="infos">

        <div class="media-heading meta info opts">
            <?php
            echo Html::a($model->user['username'], ['/people', 'id' => $model->user['username']]), '•',
            Html::a("#{$index}", "#comment{$index}", ['class' => 'comment-floor']), '•',
            Html::tag('addr', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => Yii::$app->formatter->asDatetime($model->created_at)]);
            ?>

            <span class="opts pull-right">
                <?php
                echo Html::a(
                    Html::tag('i', '', ['class' => 'fa fa-thumbs-o-up']) . ' ' . Html::tag('span', $model->like_count) . ' 个赞',
                    '#',
                    [
                        'data-do' => 'like',
                        'data-id' => $model->id,
                        'data-type' => 'comment',
                        'class' => ($model->like) ? 'active': ''
                    ]
                );
                if($model->isCurrent()){
                    echo Html::a('',
                        ['/topic/comment/update', 'id' => $model->id],
                        ['title' => '修改回帖', 'class' => 'fa fa-pencil']
                    );
                    echo Html::a('',
                        ['/topic/comment/delete', 'id' => $model->id],
                        [
                            'title' => '删除评论',
                            'class' => 'fa fa-trash',
                            'data' => [
                                'confirm' => "您确认要删除评论吗？",
                                'method' => 'post',
                            ],
                        ]
                    );
                } else{
                    echo Html::a('', '#',
                        [
                            'data-login' => $model->user['username'],
                            'data-floor' => $index,
                            'title' => '回复此楼',
                            'class' => 'fa fa-mail-reply'
                        ]
                    );
                }
                ?>
            </span>

        </div>

        <div class="media-body markdown-reply content-body">
            <?= Markdown::process($model->comment, 'gfm') ?>
        </div>
    </div>
<?php endif ?>