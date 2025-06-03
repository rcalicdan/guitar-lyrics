<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function songShow(songId, songSlug) {
        return {
            songId: songId,
            songSlug: songSlug,
            isFavorite: false,
            viewCount: Math.floor(Math.random() * 1000) + 100,
            fontSize: 'medium',
            autoScrolling: false,
            isFullscreen: false,
            showFloatingActions: false,
            showScrollTop: false,
            scrollInterval: null,
            relatedSongs: [],
            
            comments: [],
            newComment: {
                content: ''
            },
            replyContent: '',
            replyingToId: null,
            submittingComment: false,
            editingCommentId: null,
            editCommentContent: '',
            isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
            currentUserId: {{ auth()->check() ? auth()->user()->id : 'null' }},
            
            init() {
                this.loadRelatedSongs();
                this.setupScrollListeners();
                this.loadUserPreferences();
                this.loadComments();
                
                setTimeout(() => {
                    this.showFloatingActions = true;
                }, 1000);
            },

            async loadComments() {
                try {
                    const response = await axios.get(`/api/songs/${this.songSlug}/comments`);
                    
                    if (response.data.success) {
                        this.comments = response.data.data;
                    }
                } catch (error) {
                    console.error('Error loading comments:', error);
                    this.showNotification('Error loading comments', 'error');
                }
            },

            async submitComment() {
                if (!this.newComment.content.trim()) return;
                
                this.submittingComment = true;
                
                try {
                    const response = await axios.post(`/api/songs/${this.songSlug}/comments`, {
                        content: this.newComment.content
                    });
                    
                    if (response.data.success) {
                        this.comments.unshift(response.data.data);
                        this.newComment.content = '';
                        this.showNotification('Comment posted successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error posting comment', 'error');
                    }
                } catch (error) {
                    console.error('Error posting comment:', error);
                    this.showNotification(
                        error.response?.data?.message || 'Error posting comment', 
                        'error'
                    );
                } finally {
                    this.submittingComment = false;
                }
            },

            async submitReply(parentId) {
                if (!this.replyContent.trim()) return;
                
                try {
                    const response = await axios.post(`/api/songs/${this.songSlug}/comments`, {
                        content: this.replyContent,
                        parent_id: parentId
                    });
                    
                    if (response.data.success) {
                        const parentComment = this.comments.find(c => c.id === parentId);
                        if (parentComment) {
                            if (!parentComment.replies) {
                                parentComment.replies = [];
                            }
                            parentComment.replies.push(response.data.data);
                        }
                        
                        this.replyContent = '';
                        this.replyingToId = null;
                        this.showNotification('Reply posted successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error posting reply', 'error');
                    }
                } catch (error) {
                    console.error('Error posting reply:', error);
                    this.showNotification(
                        error.response?.data?.message || 'Error posting reply', 
                        'error'
                    );
                }
            },

            editComment(comment) {
                this.editingCommentId = comment.id;
                this.editCommentContent = comment.content;
            },

            async updateComment(comment) {
                try {
                    const response = await axios.patch(`/api/songs/${this.songSlug}/comments/${comment.id}`, {
                        content: this.editCommentContent
                    });
                    
                    if (response.data.success) {
                        comment.content = this.editCommentContent;
                        comment.updated_at = new Date().toISOString(); 
                        this.cancelEdit();
                        this.showNotification('Comment updated successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error updating comment', 'error');
                    }
                } catch (error) {
                    console.error('Error updating comment:', error);
                    this.showNotification(
                        error.response?.data?.message || 'Error updating comment', 
                        'error'
                    );
                }
            },

            async deleteComment(commentId) {
                if (!confirm('Are you sure you want to delete this comment?')) return;
                
                try {
                    const response = await axios.delete(`/api/songs/${this.songSlug}/comments/${commentId}`);
                    
                    if (response.data.success) {
                        this.comments = this.comments.filter(c => {
                            if (c.id === commentId) return false;
                            if (c.replies) {
                                c.replies = c.replies.filter(r => r.id !== commentId);
                            }
                            return true;
                        });
                        
                        this.showNotification('Comment deleted successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error deleting comment', 'error');
                    }
                } catch (error) {
                    console.error('Error deleting comment:', error);
                    this.showNotification(
                        error.response?.data?.message || 'Error deleting comment', 
                        'error'
                    );
                }
            },

            toggleReplyForm(commentId) {
                this.replyingToId = this.replyingToId === commentId ? null : commentId;
                this.replyContent = '';
            },

            cancelReply() {
                this.replyingToId = null;
                this.replyContent = '';
            },

            cancelEdit() {
                this.editingCommentId = null;
                this.editCommentContent = '';
            },

            showNotification(message, type = 'info') {
                alert(message);
            },

            formatNumber(num) {
                if (num >= 1000000) {
                    return (num / 1000000).toFixed(1) + 'M';
                } else if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'K';
                }
                return num.toString();
            },
            
            loadRelatedSongs() {
                const serverRelatedSongs = @json($relatedSongs);

                this.relatedSongs = serverRelatedSongs.map(song => ({
                    id: song.id,
                    title: song.title,
                    slug: song.slug,
                    artist_name: song.artist ? song.artist.name : 'Unknown Artist',
                    image_path: song.image_path || '/placeholder/no-image.png'
                }));
            },
            
            setupScrollListeners() {
                window.addEventListener('scroll', () => {
                    this.showScrollTop = window.pageYOffset > 300;
                    
                    clearTimeout(this.scrollTimeout);
                    this.scrollTimeout = setTimeout(() => {
                        this.showFloatingActions = true;
                    }, 150);
                });
            },
            
            loadUserPreferences() {
                const savedFontSize = localStorage.getItem('songFontSize');
                if (savedFontSize) {
                    this.fontSize = savedFontSize;
                }
                
                const savedAutoScroll = localStorage.getItem('autoScrolling');
                if (savedAutoScroll) {
                    this.autoScrolling = savedAutoScroll === 'true';
                }
            },
            
            saveUserPreferences() {
                localStorage.setItem('songFontSize', this.fontSize);
                localStorage.setItem('autoScrolling', this.autoScrolling.toString());
            },
            
            changeFontSize(size) {
                this.fontSize = size;
                this.saveUserPreferences();
            },
            
            toggleFavorite() {
                this.isFavorite = !this.isFavorite;
            },
            
            toggleAutoScroll() {
                this.autoScrolling = !this.autoScrolling;
                
                if (this.autoScrolling) {
                    this.startAutoScroll();
                } else {
                    this.stopAutoScroll();
                }
                
                this.saveUserPreferences();
            },
            
            startAutoScroll() {
                this.scrollInterval = setInterval(() => {
                    window.scrollBy(0, 1);
                    
                    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
                        this.stopAutoScroll();
                    }
                }, 50); 
            },
            
            stopAutoScroll() {
                if (this.scrollInterval) {
                    clearInterval(this.scrollInterval);
                    this.scrollInterval = null;
                }
                this.autoScrolling = false;
            },
            
            toggleFullscreen() {
                if (!this.isFullscreen) {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
                this.isFullscreen = !this.isFullscreen;
            },
            
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            },
            
            destroy() {
                this.stopAutoScroll();
                window.removeEventListener('scroll', this.setupScrollListeners);
            }
        }
    }
</script>