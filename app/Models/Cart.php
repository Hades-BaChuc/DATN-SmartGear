<?php
    class Cart extends Model {
        protected $fillable = ['user_id','session_id','voucher_id','status'];
        public function items(){ return $this->hasMany(CartItem::class); }
        public function user(){ return $this->belongsTo(User::class); }
    }