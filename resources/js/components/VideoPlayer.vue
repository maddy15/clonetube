<template>
    <div>
        <video 
        id="video" 
        class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" 
        controls 
        preload="auto" 
        data-setup='{"fluid" : true, "preload" : "auto", "autoplay" : true}'
        :poster="thumbnailUrl">
            <source :src="videoUrl" type="video/mp4">
        </video>
    </div>
</template>

<script>
    import videojs from 'video.js';

    export default {
        data() {
            return {
                player   : null,
                duration : 0
            }
        },
        props: {
            videoUid     : null,
            videoUrl     : null,
            thumbnailUrl : null,
        },
        methods: {
            hasHitQuotaView() {
                if(!this.duration)
                {
                    return false;
                }

                return Math.round(this.player.currentTime()) === Math.round((40 * this.duration) / 100);
            },
            createView()
            {
                axios.post(`/videos/${this.videoUid}/views`);
            }
        },
        mounted()
        {
            this.player = videojs('video');

            this.player.autoplay('muted');


            this.player.on('loadedmetadata', () => {
                this.duration = Math.round(this.player.duration());
            });

            setInterval(()=>{
                if(this.hasHitQuotaView())
                {
                    this.createView();
                }
            },1000);
        }
    }
</script>

<style lang="scss" scoped>

</style>