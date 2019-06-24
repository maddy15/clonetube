<template>
    <div>
        <p>{{ comments.length}} {{ comments.length | pluralize('comment')}}</p>

        <div class="video-comment clearfix mb-4" v-if="$root.user.authenticated">
            <textarea placeholder="Say something..." class="form-control video-comment__input" v-model="body"></textarea>

            <div class="float-right">
                <button type="submit" class="btn btn-light mt-3" @click.prevent="createComment">Submit</button>
            </div>
        </div>

        <div class="media mt-4" v-for="comment in comments" :key="comment.id">
            <a :href="'/channel/' + comment.channel.data.slug">
                <img class="mr-3" :src="comment.channel.data.image" alt="Generic placeholder image">
            </a>
            <div class="media-body">
                <h6 class="mt-0">
                    <a :href="'/channel/' + comment.channel.data.slug">{{ comment.channel.data.name }}</a> {{ comment.created_at_human }}
                </h6>
                <p>{{ comment.body }}</p>
            
                <ul class="list-inline" v-if="$root.user.authenticated">
                    <li  class="list-inline-item">
                        <a href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible == comment.id ? 'Cancel' : 'Reply' }}</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" v-if="$root.user.id == comment.user_id" @click.prevent="deleteComment(comment.id)">Delete</a>
                    </li>
                </ul>

                <div class="video-comment clear" v-if="replyFormVisible == comment.id">
                    <textarea v-model="replyBody" class="form-control"></textarea>
                    <div class="float-right">
                        <button type="submit" class="btn btn-light mt-3" @click.prevent="createReply(comment.id)">Submit</button>
                    </div>
                </div>
                
                <div class="media mt-4" v-for="reply in comment.replies.data" :key="reply.id">
                    <a :href="'/channel/' + reply.channel.data.slug" class="mr-3">
                        <img class="mr-3" :src="reply.channel.data.image" alt="Generic placeholder image">
                    </a>
                    <div class="media-body">
                        <h6 class="mt-0">
                            <a :href="'/channel/' + reply.channel.data.slug">{{ reply.channel.data.name }}</a> {{ reply.created_at_human }}
                        </h6>
                        <p>{{ reply.body }}</p>

                        <ul class="list-inline" v-if="$root.user.id == reply.user_id">
                            <li class="list-inline-item">
                                <a href="#"  @click.prevent="deleteComment(reply.id)">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Vue2Filters from 'vue2-filters'
    export default {
        props: {
            videoUid : null
        },
        data() {
            return {
                comments : [],
                body : null,
                replyBody : null,
                replyFormVisible : null
            }
        },
        methods: {
            getComments() {
                axios.get(`/videos/${this.videoUid}/comments`)
                    .then(res => this.comments = res.data.data);
            },
            createComment()
            {
                axios.post(`/videos/${this.videoUid}/comments`, {
                    body : this.body
                }).then((res) => {
                        this.body = null;
                        this.getComments();
                    });
            },
            createReply(commentId)
            {

                axios.post(`/videos/${this.videoUid}/comments`, {
                    body : this.replyBody,
                    reply_id : commentId
                }).then((res) => {
                        this.comments.map((comment,index) => {
                            if(comment.id === commentId)
                            {
                                this.comments[index].replies.data.push(res.data.data);
                                return;
                            }
                        });

                        this.replyBody = null;
                        this.replyFormVisible = null;
                    });
            },
            deleteComment(commentId)
            {   
                if(!confirm('Are you sure you want to delete this comment?')) return;

                this.deleteById(commentId);

                axios.delete(`/videos/${this.videoUid}/comments/${commentId}`);
            },
            deleteById(commentId)
            {
                this.comments.map((comment,index) => {
                    if(comment.id == commentId)
                    {
                        this.comments.splice(index,1);
                        return;
                    }

                    comment.replies.data.map((reply,i) => {
                        if(reply.id == commentId)
                        {
                            this.comments[index].replies.data.splice(i,1);
                            return;
                        }
                    })
                });
            },
            toggleReplyForm(commentId)
            {
                this.replyBody = null;
                if(this.replyFormVisible === commentId)
                {
                    this.replyFormVisible = null;
                    return;
                } 
                this.replyFormVisible = commentId;
            }
        },
        created()
        {
            this.getComments();
        },
        mixins: [Vue2Filters.mixin],
    }
</script>

<style lang="scss" scoped>

</style>