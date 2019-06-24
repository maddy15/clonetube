<template>
        <div class="video__voting">
            <a class="video__voting-button" :class="{ 'video__voting-button--voted' : votingDetails.user_vote == 'up' }" @click.prevent="vote('up')">
                <i class="fas fa-thumbs-up" style="cursor:pointer"></i>
            </a> {{ votingDetails.up }} &nbsp;
            <a class="video__voting-button" :class="{ 'video__voting-button--voted' : votingDetails.user_vote == 'down' }" @click.prevent="vote('down')">
                <i class="fas fa-thumbs-down" style="cursor:pointer"></i>
            </a> {{ votingDetails.down }} &nbsp;
        </div> 
</template>

<script>
    export default {
        props: {
            videoUid : null
        },
        data() {
            return {
                votingDetails: {
                    up : null,
                    down : null,
                    user_vote : null,
                    canVote : false
                }
            }
        },
        methods: {
            getVotes() {
                axios.get(`/videos/${this.videoUid}/votes`)
                    .then( res => this.votingDetails = res.data.data);
            },
            vote(type)
            {
                if(this.votingDetails.user_vote == type) {
                    this.votingDetails[type]--;
                    this.votingDetails.user_vote = null;
                    this.deleteVote(type);
                    return;
                }

                if(this.votingDetails.user_vote)
                {
                    this.votingDetails[type == 'up' ? 'down' : 'up']--; 
                }

                this.votingDetails[type]++;
                this.votingDetails.user_vote = type;
                this.createVote(type);
                
            },
            deleteVote(type)
            {
                axios.delete(`/videos/${this.videoUid}/votes`,null).then(res => console.log(res));
            },
            createVote(type)
            {
                axios.post(`/videos/${this.videoUid}/votes`,{type});
            }
        },
        created()
        {
            this.getVotes();
        }
    }
</script>

<style lang="scss" scoped>

</style>