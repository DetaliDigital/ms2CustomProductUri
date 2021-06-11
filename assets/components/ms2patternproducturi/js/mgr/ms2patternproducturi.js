Ext.onReady(function(){
    Ext.getCmp('modx-resource-uri').setDisabled(true);
    Ext.getCmp('modx-resource-uri-override').setDisabled(true);
});

Ext.override(MODx.panel.Resource,{
    ms2PatternProductUriSettingRightFieldset: MODx.panel.Resource.prototype.getSettingRightFieldset,
    getSettingRightFieldset: function(config){
        var ms2PatternProductUriSettingRightDataFieldset = this.ms2PatternProductUriSettingRightFieldset.call(this,config);
        ms2PatternProductUriSettingRightDataFieldset.push({
            xtype: 'label',
            html: 'Поля "Заморозить URI" и URI заблокированы пакетом ms2PatternProductUri, так как URI формируются автоматически',
            cls: 'desc-under'
        });

        return ms2PatternProductUriSettingRightDataFieldset;
    }
});