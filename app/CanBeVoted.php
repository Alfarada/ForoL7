<?php 

namespace App;
use Collective\Html\HtmlFacade as Html;

trait CanBeVoted
{   
    public function votes()
    {
        return $this->morphMany(Vote::class,'votable');
    }

    public function getCurrentVoteAttribute()
    {
        if (auth()->check()) {
            return $this->getVoteFrom(auth()->user());
        }
    }

    public function getVoteComponentAttribute()
    {
        return Html::tag('app-vote','', [
            'post_id'=> $this->id,
            'score'=> $this->score,
            'vote'=> $this->current_vote
        ]);
    }

    public function getVoteFrom(User $user)
    {   
        return $this->votes()
                ->where('user_id', $user->id)
                ->value('vote'); //+1, -1 and null
    }

    public function upvote()
    {
        $this->addVotes(1);
    }

    public function downvote()
    {
        $this->addVotes(-1);
    }

    protected function addVotes($amount)
    {
        $this->votes()->updateOrCreate( // votable_id, votable_type
            ['user_id' => auth()->id()],
            ['vote' => $amount]
        );

        $this->refreshPostScore();
    }

    public function undoVote()
    {   
        $this->votes()
            ->where('user_id', auth()->id())
            ->delete();
            
        $this->refreshPostScore();
    }

    protected function refreshPostScore()
    {   
        $this->score = $this->votes()->sum('vote');
            
        $this->save();
    }
}

