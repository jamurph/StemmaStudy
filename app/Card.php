<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Te7aHoudini\LaravelTrix\Models\TrixAttachment;
use Te7aHoudini\LaravelTrix\Models\TrixRichText;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


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

                //move each attachment to user folder.
                $trixAttachments = TrixAttachment::whereIn('attachment', is_string($attachments) ? json_decode($attachments) : $attachments)->get();

                foreach($trixAttachments as $attachment){
                    if(Str::startsWith($attachment->attachment, 'tmp')){

                            $oldpath = $attachment->attachment;
                            $filename = Str::substr($oldpath, 4);
                            $newpath = $attachment->user_id . '/' . $filename;
        
                            $resized = Image::make(Storage::get($oldpath))->resize(1280, 6400, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
        
                            //insert onto white canvas. This will make png->jpg background white instead of black. Also cut images that are too tall.
                            $jpg = Image::canvas($resized->width(), $resized->height(), '#ffffff');
                            $jpg->insert($resized);
                            $resized = $jpg->encode('jpg', 90);
                            
                            $attached = Storage::put($newpath, (string)$resized);

                            if($attached){
                                $attachment->update([
                                    'is_pending' => 0,
                                    'attachable_id' => $model->id,
                                    'attachment' => $newpath
                                ]);
                            }
                        
                    }
                }
            }

            $model->savedTrixFields = [];
        });
    }
}
