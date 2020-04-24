function Common_Lib(){}

Common_Lib.prototype = {

    AJAX_ERR_MSG: '\u901a\u4fe1\u30a8\u30e9\u30fc',　//通信エラー

    SEL_SPINNER_OVERLAY : '_js_spinner_overlay',
    SEL_SPINNER_COVER : '_js_spinner_cover',
    SEL_SPINNER : '_js_spinner',
    SEL_MODAL : '._js_modal_',
    SEL_MODAL_OPEN : '._js_modal_open',
    SEL_MODAL_CLOSE : '._js_modal_close',
    SEL_SESSION_MESSAGE : '._js_session_message',

    DISP_MODAL_SPEED : 100,
    DISP_LOADING_SPEED : 300,

    nowModal : null,

    /**
     * 初期設定
     */
    Init : function()
    {
        this._SetSpinner();
        this._SetModalEvent();
    },

    /**
     * ローディング初期設定
     */
    _SetSpinner : function()
    {
        const aOverlay = $('<div class="' + this.SEL_SPINNER_OVERLAY + ' c-spinner-overlay"></div>');
        const aCoverSpinner = $('<div class="'+ this.SEL_SPINNER_COVER + ' c-spinner-cover"></div>');
        const aSpinner = $('<div class="'+ this.SEL_SPINNER +' c-spinner"></div>');
        aCoverSpinner.append( aSpinner );
        aOverlay.append( aCoverSpinner );
        aOverlay.appendTo('body');
    },

    /**
     * ローディング表示
     */
    ShowWait : function () {
        $('.' + this.SEL_SPINNER_OVERLAY).fadeIn(this.DISP_LOADING_SPEED);
    },

    /**
     * ローディング非表示
     */
    HideWait : function ()
    {
        $('.' + this.SEL_SPINNER_OVERLAY).fadeOut(this.DISP_LOADING_SPEED);
    },

    // /**
    //  * セッションメッセージ表示
    //  */
    // ShowSessionMessage : function()
    // {
    //     const aMsgObj = $(this.SEL_SESSION_MESSAGE);
    //     aMsgObj.fadeIn(100);
    //     setTimeout( function () {
    //         aMsgObj.fadeOut(100);
    //     },3000);
    // },

    /**
     * モーダルイベント設定
     */
    _SetModalEvent : function()
    {
        const aThis = this;

        $(document).on('click', aThis.SEL_MODAL_OPEN ,function () {
            const aTarget = $(this).data('target');

            if ( typeof (aTarget) === undefined || aTarget === null || aTarget === '' )
            {
                return false;
            }

            aThis.nowModal = $(aThis.SEL_MODAL + aTarget);
            if ( !aThis.nowModal )
            {
                return false;
            }

            const aModalBg = $('<div class="c-modal__bg _js_modal_close"></div>');
            aThis.nowModal.appendTo('body');
            aThis.nowModal.prepend(aModalBg);
            aThis.nowModal.fadeIn(aThis.DISP_MODAL_SPEED);

            $(document).on('click', aThis.SEL_MODAL_CLOSE, function () {
                aModalBg.remove();
                aThis.nowModal.fadeOut(aThis.DISP_MODAL_SPEED);
            })
        });
    },

    /**
     * Ajaxリクエスト
     *
     * @param {string} pUrl AjaxURL
     * @param {object} pData POSTデータ
     * @param {function} pSuccessCallback 通信成功時に実行する関数
     * @param {function} pErrCallback 通信失敗時に実行する関数
     * @returns Promise
     */
    Request : function(pUrl, pData, pSuccessCallback, pErrCallback)
    {
        const aThis = this;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        return $.ajax({
            type: 'POST',
            url: pUrl,
            data:  JSON.stringify(pData) ,
            dataType: 'json',
            contentType: 'application/json',
            success: function( pData, pStatus )
            {
                if ( typeof pSuccessCallback === 'function')
                {
                    pSuccessCallback( pData, pStatus );
                }
            },
            error: function( pData, pStatus, pError )
            {
                if ( typeof pErrCallback === 'function' )
                {
                    pErrCallback( pData, pStatus, pError )
                }
                else
                {
                    console.log( pData, pStatus, pError );
                    alert( aThis.AJAX_ERR_MSG );
                }
                return false;
            },
        });
    },
};

$(function () {
    Common_Lib.prototype.Init();
    window.Common_Lib = new Common_Lib();
});
