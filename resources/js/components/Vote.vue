<template>
  <div>
    <form action>
      <button
        @click.prevent="upvote"
        :class="currentVote == 1 ? 'btn-primary': 'btn-light'"
        class="btn"
      >+1</button>
      Puntuación actual:
      <strong id="current-score">{{ currentScore }}</strong>

      <button
        @click.prevent="downvote"
        :class="currentVote == -1 ? 'btn-primary': 'btn-light'"
        class="btn"
      >-1</button>
    </form>
  </div>
</template>

<script>
export default {
  props: ["score", "vote"],
  data() {
    return {
      currentVote: this.vote ? parseInt(this.vote) : null,
      currentScore: parseInt(this.score)
    };
  },
  methods: {
    upvote() {
      this.addVote(1);
    },
    downvote() {
      this.addVote(-1);
    },
    addVote(amount) {
      if (this.currentVote == amount) {
        this.currentScore -= this.currentVote;
        axios.delete(window.location.href + '/vote');
        this.currentVote = null;
        
      } else {
        this.currentScore += this.currentVote ? (amount * 2) : amount;
        axios.post(window.location.href + (amount == 1 ? '/upvote' : '/downvote'))
        this.currentVote = amount;
      }
    },
  },
};
</script>