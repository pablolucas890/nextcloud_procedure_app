import Vue from 'vue'
import VueClipboard from 'vue-clipboard2'
import { translate as t, translatePlural as n } from '@nextcloud/l10n'

import SharingTab from './views/ProcedureTab'

Vue.prototype.t = t
Vue.prototype.n = n
Vue.use(VueClipboard)

// Init Sharing tab component
const TabI = Vue.extend(SharingTab)
let TabProcedure = null

// Aqui aplica a aba do menu de detalhes
window.addEventListener('DOMContentLoaded',async function () {
    await new Promise(r => setTimeout(r, 3000));
    var elementos = document.getElementsByClassName("editor__content");
    elementos[0].style.backgroundImage = "URL(../../../apps/procedure/src/assets/obsolete.jpg)"
    console.log("elementos", elementos[0])
    if (OCA.Files && OCA.Files.Sidebar) {
        OCA.Files.Sidebar.registerTab(new OCA.Files.Sidebar.Tab({
            id: 'procedure',
            name: t('procedure', 'Procedure'),
            icon: 'icon-file',

            async mount(el, fileInfo, context) {
                if (TabProcedure) {
                    TabProcedure.$destroy()
                }
				TabProcedure = new TabI({
					parent: context,
				})
                // File Info sao informacoes do Arquivo
                TabProcedure.$mount(el)
            },
            update(fileInfo) {
                TabInstance.update(fileInfo)
            },
            destroy() {
                TabInstance.$destroy()
                TabInstance = null
            },
        }))
    }
})
