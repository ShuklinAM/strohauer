jQuery.fn.customInputs = function(options){
    jQuery(this).each(function(){
        var $_this = jQuery(this);

        if ($_this.data('customInputs')) return;

        var customInputs = new ISM.customInputs(this, options);
        $_this.data('customInputs', customInputs);
    });
}; //<!>

jQuery.fn.customInputs = function(options){
    jQuery(this).each(function(){
        var $_this = jQuery(this);

        if ($_this.data('customInputs')) return;

        var customInputs = new ISM.customInputs(this, options);
        $_this.data('customInputs', customInputs);
    });
}; //<!>

//****************** Constructor *************************//

ISM.customInputs = function(el, options){
    if (!el) return;
    this.el = jQuery(el);
    this.settings = jQuery.extend(true, {
        classes : {
            prefix:                 'custom-',
            disabled:               'disabled',
            selected:               'selected',
            hidden:                 'hidden'
        }
    }, options || {});

    this.init();
}; // <!>


//****************** Prototype of Object *************************//

ISM.customInputs.prototype = {
    init :  function(){
        this.type = this.el[0].type;

        this.cls = this.settings.classes.prefix + this.type;

        this.el.wrap('<span class="'+ this.cls +'" />');
        this.wrapper = this.el.parent();

        if ( this.isRadio()){
            this.elGroup = jQuery('input[name="'+ this.el[0].name +'"]');
            this.setMark = this.setMarkRadio;
        } else{
            this.setMark = this.setMarkCheckbox;
        };

        this.el.bind('click.customInputs', jQuery.proxy(this.setMark, this));
        this.setMark();
       // this.isHidden() && this.hide();
        this.isDisabled() && this.disabled(true);
    },
    refresh : function(){
        this.setMark();
        this.isHidden() && this.hide();
        this.isDisabled() && this.disabled(true);
    },
    isRadio : function(){
        return this.el[0].type === 'radio';
    },
    isCheckbox : function(){
        return this.el[0].type === 'checkbox';
    },
    isText : function(){
        return this.el[0].type === 'text';
    },
    isHidden : function(){
        return this.el.is(':hidden');
    },
    isDisabled : function(){
        return this.el[0].disabled;
    },
    setMarkRadio : function(){
        this.elGroup.each(jQuery.proxy(function(indx, item){
            var $_this = jQuery(item);
            if ($_this.is(':checked')){
                this.mark($_this.parent('.' + this.cls));
            } else{
                this.unmark($_this.parent('.' + this.cls));
            }
        }, this));
    },
    setMarkCheckbox :  function(){
        if (this.el.is(':checked')){
            this.mark(this.wrapper);
        } else{
            this.unmark(this.wrapper);
        }
    },
    mark : function(el){
        el.addClass(this.settings.classes.prefix + this.settings.classes.selected);
    },
    unmark : function(el){
        el.removeClass(this.settings.classes.prefix + this.settings.classes.selected);
    },
    hide : function(){
        this.wrapper.addClass(this.settings.classes.prefix + this.settings.classes.hidden);
    },
    show : function(){
        this.wrapper.removeClass(this.settings.classes.prefix + this.settings.classes.hidden);
    },
    disable: function(flag){
        if (flag || typeof flag === "undefined"){
            this.wrapper.addClass(this.settings.classes.prefix + this.settings.classes.disabled);
            this.el[0].disabled = true;
            this.el.unbind('click.customInputs', jQuery.proxy(this.setMark, this));
        } else{
            this.wrapper.removeClass(this.settings.classes.prefix + this.settings.classes.disabled);
            this.el[0].disabled = false;
            this.el.bind('click.customInputs', jQuery.proxy(this.setMark, this));
        };
    }
}; // <!>