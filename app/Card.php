<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Te7aHoudini\LaravelTrix\Models\TrixAttachment;
use Te7aHoudini\LaravelTrix\Models\TrixRichText;

class Card extends Model
{
    Use HasTrixRichText;

    protected $guarded = [];

    public function set(){
        return $this->belongsTo(Set::class);
    }

    public function connectionsIn(){
        return $this->hasMany(Connection::class, 'to_card_id');
    }

    public function connectionsOut(){
        return $this->hasMany(Connection::class, 'from_card_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'card_tag');
    }

    public function assessmentCards(){
        return $this->hasMany(AssessmentCard::class, 'card_id');
    }

    public function trixRender($field)
    {
        try {
            return $this->trixRichText->where('field', $field)->first()->content;
        } catch (Exception $e){
            //this shouldn't happen for Cards created by users 
            return $this->definition;
        }
    }


    //override laravel trix boot for saving and saved events. 
    public static function bootHasTrixRichText()
    {
        static::saving(function ($model) {
            $trixInputName = Str::lower(class_basename($model)).'-trixFields';

            $model->savedTrixFields = Arr::get($model, $trixInputName, []);

            $model->savedAttachments = Arr::get($model, 'attachment-'.$trixInputName, []);

            unset($model->$trixInputName);
            unset($model->{'attachment-'.$trixInputName});
        });

        static::saved(function ($model) {
            foreach ($model->savedTrixFields as $field => $content) {
                TrixRichText::updateOrCreate([
                    'model_id' => $model->id,
                    'model_type' => $model->getMorphClass(),
                    'field' => $field,
                ], [
                    'field' => $field,
                    'content' => $content,
                ]);

                $attachments = Arr::get($model->savedAttachments, $field, []);

                TrixAttachment::whereIn('attachment', is_string($attachments) ? json_decode($attachments) : $attachments)
                    ->update([
                        'is_pending' => 0,
                        'attachable_id' => $model->id,
                    ]);
            }

            $model->savedTrixFields = [];
        });
    }
}
