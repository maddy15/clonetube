<template>
    <div class="subscribe-button" v-if="subscribers !== null">
        {{ subscribers }} {{ subscribers | pluralize('Subscriber')}} &nbsp; 
        <button type="button" class="btn btn-xs btn-danger" v-if="canSubscribe" @click.prevent="handle()">{{ userSubscribed ? 'Unsubscribe' : 'Subscribe' }}</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                subscribers: null,
                userSubscribed : false,
                canSubscribe : false
            }
        },
        props:{
            channelSlug : null
        },
        methods: {
            getSubscriptionStatus() {
                axios.get(`/subscription/${this.channelSlug}`)
                    .then((res) => {
                        this.subscribers = res.data.data.count;
                        this.userSubscribed = res.data.data.user_subscribed;
                        this.canSubscribe = res.data.data.can_subscribe;
                    });
            },
            handle()
            {
                if(this.userSubscribed)
                {
                    this.unsubscribe();
                }
                else
                {
                    this.subscribe();
                }

            },
            subscribe()
            {
                this.userSubscribed = true;
                this.subscribers++;
                axios.post(`/subscription/${this.channelSlug}`);
            },
            unsubscribe()
            {
                this.userSubscribed = false;
                this.subscribers--;
                axios.delete(`/subscription/${this.channelSlug}`);
            }
        },
        created()
        {
            this.getSubscriptionStatus();
        }
    }
</script>

<style lang="scss" scoped>

</style>