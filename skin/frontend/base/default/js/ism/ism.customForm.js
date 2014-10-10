window.ISM = window.ISM || {};

(function($){
    $(document).ready(function(){
        ISM.customSelectWrapper.init('select');
        $('input[type="radio"], input[type="checkbox"]').customInputs();
    });
})(jQuery);

/************************* Custom Select ***************************************/

ISM.customSelectWrapper = {
    init: function(el){
        jQuery(el).selectik();
    },
    refresh: function(el){
        if (!ISM.customSelectWrapper.iscustomSelectWrapper(el)){
            jQuery(el).selectik();
            return;
        };
        jQuery(el).data('selectik').refreshCS();
    },
    show: function(el){
        if (!ISM.customSelectWrapper.iscustomSelectWrapper(el)) return;
        jQuery(el).data('selectik').hiddenCS(0);
    },
    hide: function(el){
        if (!ISM.customSelectWrapper.iscustomSelectWrapper(el)) return;
        jQuery(el).data('selectik').hiddenCS(1);
    },
    enable: function(el){
        if (!ISM.customSelectWrapper.iscustomSelectWrapper(el)) return;
        jQuery(el).data('selectik').enableCS();
    },
    disable: function(el){
        if (!ISM.customSelectWrapper.iscustomSelectWrapper(el)) return;
        jQuery(el).data('selectik').disableCS();
    },
    changeValue: function(el, value){
        if (!ISM.customSelectWrapper.iscustomSelectWrapper(el)) return;
        jQuery(el).data('selectik').changeCS(value);
    },
    iscustomSelectWrapper: function(el){
        return !!jQuery(el).data('selectik');
    }
}; //<!>

/************************* Custom Radiobuttons and Checkboxes ***************************************/

ISM.customInputsWrapper = {
    init: function(el, options){
        jQuery(el).customInputs(options);
    },
    refresh: function(el){
        if (!ISM.customInputsWrapper.isCI(el)) return;
        jQuery(el).data('customInputs').refresh(el);
    },
    mark: function(el){
        if (!ISM.customInputsWrapper.isCI(el)) return;
        jQuery(el).data('customInputs').setMark();
    },
    unmark: function(el){
        if (!ISM.customInputsWrapper.isCI(el)) return;
        jQuery(el).data('customInputs').setMark();
    },
    show: function(el){
        if (!ISM.customInputsWrapper.isCI(el)) return;
        jQuery(el).data('customInputs').show();
    },
    hide: function(el){
        if (!ISM.customInputsWrapper.isCI(el)) return;
        jQuery(el).data('customInputs').hide();
    },
    disable: function(el, flag){
        if (!ISM.customInputsWrapper.isCI(el)) return;
        jQuery(el).data('customInputs').disable(flag);
    },
    isCI: function(el){
        return !!jQuery(el).data('customInputs');
    }
}; //<!>




/********************************** Magento rewrites of handlers  *******************************/


document.observe("dom:loaded", function() {
    if (window.Billing){
         Billing.prototype.setUseForShipping = Billing.prototype.setUseForShipping.wrap(function(oldfunc, flag) {
             $('shipping:same_as_billing').checked = flag;
             ISM.customInputsWrapper.mark($('shipping:same_as_billing'));
         });
    };

    if(window.Shipping){
        Shipping.prototype.syncWithBilling = Shipping.prototype.syncWithBilling.wrap(function() {
            $('billing-address-select') && this.newAddress(!$('billing-address-select').value);
            $('shipping:same_as_billing').checked = true;
            ISM.customInputsWrapper.mark($('shipping:same_as_billing'));
            if (!$('billing-address-select') || !$('billing-address-select').value) {
                arrElements = Form.getElements(this.form);
                for (var elemIndex = 0; elemIndex < arrElements.length; elemIndex++) {
                    if (arrElements[elemIndex].id) {
                        var sourceField = $(arrElements[elemIndex].id.replace(/^shipping:/, 'billing:'));
                        if (sourceField){
                            arrElements[elemIndex].value = sourceField.value;
                        }
                    }
                };
                shippingRegionUpdater.update();
                $('shipping:region_id').value = $('billing:region_id').value;
                $('shipping:region').value = $('billing:region').value;

                ISM.customSelectWrapper.refresh($('shipping:region_id'));
                ISM.customSelectWrapper.refresh($('shipping:country_id'));
            } else {
                $('shipping-address-select').value = $('billing-address-select').value;
                ISM.customSelectWrapper.refresh($('shipping-address-select'));
            };
        });


        Shipping.prototype.setSameAsBilling = Shipping.prototype.setSameAsBilling.wrap(function(oldfunc, flag) {
            $('shipping:same_as_billing').checked = flag;
            ISM.customInputsWrapper.mark($('shipping:same_as_billing'));
            if (flag) {
                this.syncWithBilling();
            }
        });
    };

    if(window.Accordion){
        Accordion.prototype.openSection = Accordion.prototype.openSection.wrap(function(oldfunc, section) {
            oldfunc(section);
            ISM.customSelectWrapper.init('select');
            ISM.customInputsWrapper.init('input[type="radio"], input[type="checkbox"]');
        });

    };
});


if(window.RegionUpdater){
    RegionUpdater.prototype.initialize = RegionUpdater.prototype.initialize.wrap(function(origfunc, countryEl, regionTextEl, regionSelectEl, regions, disableAction, zipEl) {
            origfunc(countryEl, regionTextEl, regionSelectEl, regions, disableAction, zipEl);
            Event.observe(this.countryEl, 'blur', this.update.bind(this));
        }
    );
    RegionUpdater.prototype.update = RegionUpdater.prototype.update.wrap(function() {
            if (this.regions[this.countryEl.value]) {
                var i, option, region, def;

                def = this.regionSelectEl.getAttribute('defaultValue');
                if (this.regionTextEl) {
                    if (!def) {
                        def = this.regionTextEl.value.toLowerCase();
                    }
                    this.regionTextEl.value = '';
                }

                this.regionSelectEl.options.length = 1;
                for (regionId in this.regions[this.countryEl.value]) {
                    region = this.regions[this.countryEl.value][regionId];

                    option = document.createElement('OPTION');
                    option.value = regionId;
                    option.text = region.name.stripTags();
                    option.title = region.name;

                    if (this.regionSelectEl.options.add) {
                        this.regionSelectEl.options.add(option);
                    } else {
                        this.regionSelectEl.appendChild(option);
                    }

                    if (regionId==def || (region.name && region.name.toLowerCase()==def) ||
                        (region.name && region.code.toLowerCase()==def)
                        ) {
                        this.regionSelectEl.value = regionId;
                    }
                }

                if (this.disableAction=='hide') {
                    if (this.regionTextEl) {
                        this.regionTextEl.style.display = 'none';
                    };

                    ISM.customSelectWrapper.refresh(this.regionSelectEl);
                    ISM.customSelectWrapper.show(this.regionSelectEl);
                    this.regionSelectEl.style.display = '';

                } else if (this.disableAction=='disable') {
                    if (this.regionTextEl) {
                        this.regionTextEl.disabled = true;
                    };

                    ISM.customSelectWrapper.enable(this.regionSelectEl);
                    this.regionSelectEl.disabled = false;
                }
                this.setMarkDisplay(this.regionSelectEl, true);
            } else {
                if (this.disableAction=='hide') {
                    if (this.regionTextEl) {
                        this.regionTextEl.style.display = '';
                    };
                    ISM.customSelectWrapper.refresh(this.regionSelectEl);
                    ISM.customSelectWrapper.hide(this.regionSelectEl);
                    this.regionSelectEl.style.display = 'none';

                    Validation.reset(this.regionSelectEl);
                } else if (this.disableAction=='disable') {
                    if (this.regionTextEl) {
                        this.regionTextEl.disabled = false;
                    }
                    if (ISM.customSelectWrapper.iscustomSelectWrapper(this.regionSelectEl)) {
                        ISM.customSelectWrapper.disable(this.regionSelectEl);
                    };
                    this.regionSelectEl.disabled = true;
                } else if (this.disableAction=='nullify') {
                    this.regionSelectEl.options.length = 1;
                    this.regionSelectEl.value = '';
                    this.regionSelectEl.selectedIndex = 0;
                    this.lastCountryId = '';
                }
                this.setMarkDisplay(this.regionSelectEl, false);
            }
        }
    );
};

if (window.Product){
    Product.Config.prototype.initialize = Product.Config.prototype.initialize.wrap(function(oldfunc, config){
        this.config     = config;
        this.taxConfig  = this.config.taxConfig;
        if (config.containerId) {
            this.settings   = $$('#' + config.containerId + ' ' + '.super-attribute-select');
        } else {
            this.settings   = $$('.super-attribute-select');
        }
        this.state      = new Hash();
        this.priceTemplate = new Template(this.config.template);
        this.prices     = config.prices;

        // Set default values from config
        if (config.defaultValues) {
            this.values = config.defaultValues;
        }

        // Overwrite defaults by url
        var separatorIndex = window.location.href.indexOf('#');
        if (separatorIndex != -1) {
            var paramsStr = window.location.href.substr(separatorIndex+1);
            var urlValues = paramsStr.toQueryParams();
            if (!this.values) {
                this.values = {};
            }
            for (var i in urlValues) {
                this.values[i] = urlValues[i];
            }
        }

        // Overwrite defaults by inputs values if needed
        if (config.inputsInitialized) {
            this.values = {};
            this.settings.each(function(element) {
                if (element.value) {
                    var attributeId = element.id.replace(/[a-z]*/, '');
                    this.values[attributeId] = element.value;
                }
            }.bind(this));
        }

        // Put events to check select reloads
        this.settings.each(function(element){
            Event.observe(element, 'blur', this.configure.bind(this))
        }.bind(this));

        // fill state
        this.settings.each(function(element){
            var attributeId = element.id.replace(/[a-z]*/, '');
            if(attributeId && this.config.attributes[attributeId]) {
                element.config = this.config.attributes[attributeId];
                element.attributeId = attributeId;
                this.state[attributeId] = false;
            }
        }.bind(this))

        // Init settings dropdown
        var childSettings = [];
        for(var i=this.settings.length-1;i>=0;i--){
            var prevSetting = this.settings[i-1] ? this.settings[i-1] : false;
            var nextSetting = this.settings[i+1] ? this.settings[i+1] : false;
            if (i == 0){
                this.fillSelect(this.settings[i])
            } else {
                this.settings[i].disabled = true;
            }
            $(this.settings[i]).childSettings = childSettings.clone();
            $(this.settings[i]).prevSetting   = prevSetting;
            $(this.settings[i]).nextSetting   = nextSetting;
            childSettings.push(this.settings[i]);
        }

        // Set values to inputs
        this.configureForValues();
        document.observe("dom:loaded", this.configureForValues.bind(this));
    });
    Product.Config.prototype.configureElement = Product.Config.prototype.configureElement.wrap(function(oldfunc, element){
        this.reloadOptionLabels(element);
        if(element.value){
            this.state[element.config.id] = element.value;
            if(element.nextSetting){
                element.nextSetting.disabled = false;
                this.fillSelect(element.nextSetting);
                this.resetChildren(element.nextSetting);
                ISM.customSelectWrapper.enable(element.nextSetting);
                ISM.customSelectWrapper.refresh(element.nextSetting);
            }
        }
        else {
            this.resetChildren(element);
        }
        this.reloadPrice();
    });


    Product.Config.prototype.resetChildren = Product.Config.prototype.resetChildren.wrap(function(oldfunc, element){
        if(element.childSettings) {
            for(var i=0;i<element.childSettings.length;i++){
                element.childSettings[i].selectedIndex = 0;
                element.childSettings[i].disabled = true;
                ISM.customSelectWrapper.disable(element.childSettings[i]);
                ISM.customSelectWrapper.changeValue(element.childSettings[i], element.childSettings[i].options[0]);
                if(element.config){
                    this.state[element.config.id] = false;
                }
            }
        }
    });
};

if (window.Validation){
    Validation.test = Validation.test.wrap(function(oldfunc, name, elm, useTitle){
        var v = Validation.get(name);
        var prop = '__advice'+name.camelize();
        try {
            if(Validation.isVisible(elm) && !v.test($F(elm), elm)) {
                //if(!elm[prop]) {
                var advice = Validation.getAdvice(name, elm);
                if (advice == null) {
                    advice = this.createAdvice(name, elm, useTitle);
                }
                this.showAdvice(elm, advice, name);
                this.updateCallback(elm, 'failed');
                //}
                elm[prop] = 1;
                if (!elm.advaiceContainer) {
                    elm.removeClassName('validation-passed');
                    elm.addClassName('validation-failed');
                }

                if (Validation.defaultOptions.addClassNameToContainer && Validation.defaultOptions.containerClassName != '') {
                    var container = elm.up(Validation.defaultOptions.containerClassName);
                    if (container && this.allowContainerClassName(elm)) {
                        container.removeClassName('validation-passed');
                        container.addClassName('validation-error');
                    }
                }
                if (ISM.customSelectWrapper.iscustomSelectWrapper(elm)){
                    var container = elm.up();
                    if (container && this.allowContainerClassName(elm)) {
                        container.removeClassName('validation-passed');
                        container.addClassName('validation-error');
                    }
                };
                return false;
            } else{
                var advice = Validation.getAdvice(name, elm);
                this.hideAdvice(elm, advice);
                this.updateCallback(elm, 'passed');
                elm[prop] = '';
                elm.removeClassName('validation-failed');
                elm.addClassName('validation-passed');
                if (Validation.defaultOptions.addClassNameToContainer && Validation.defaultOptions.containerClassName != '') {
                    var container = elm.up(Validation.defaultOptions.containerClassName);
                    if (container && !container.down('.validation-failed') && this.allowContainerClassName(elm)) {
                        if (!Validation.get('IsEmpty').test(elm.value) || !this.isVisible(elm)) {
                            container.addClassName('validation-passed');
                        } else {
                            container.removeClassName('validation-passed');
                        }
                        container.removeClassName('validation-error');
                    }
                }
                if (ISM.customSelectWrapper.iscustomSelectWrapper(elm)){
                    var container = elm.up();
                    if (container && !container.down('.validation-failed') && this.allowContainerClassName(elm)) {
                        if (!Validation.get('IsEmpty').test(elm.value) || !this.isVisible(elm)) {
                            container.addClassName('validation-passed');
                        } else {
                            container.removeClassName('validation-passed');
                        }
                        container.removeClassName('validation-error');
                    }
                };
                return true;
            }
        } catch(e) {
            alert(e)
            throw(e)
        }
    });
};

if (window.Checkout){
    Checkout.setBilling = Checkout.setBilling.wrap(function(oldfunc){
        if (($('billing:use_for_shipping_yes')) && ($('billing:use_for_shipping_yes').checked)) {
            shipping.syncWithBilling();
            $('opc-shipping').addClassName('allow');
            this.gotoSection('shipping_method');
        } else if (($('billing:use_for_shipping_no')) && ($('billing:use_for_shipping_no').checked)) {
            $('shipping:same_as_billing').checked = false;
            ISM.customInputsWrapper.unmark($('shipping:same_as_billing'));
            this.gotoSection('shipping');
        } else {
            $('shipping:same_as_billing').checked = true;
            ISM.customInputsWrapper.mark($('shipping:same_as_billing'));
            this.gotoSection('shipping');
        }

        // this refreshes the checkout progress column
        this.reloadProgressBlock();
    });
};