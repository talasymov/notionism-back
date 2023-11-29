import {reactive} from 'vue'

export const builder_store = reactive({
    items: [{
        "component": "main",
        "children": [{
            "component": "html",
            "config": {"source": "<h3>Hello dolly</h3>", "classes": ""}
        }, {
            "component": "image",
            "config": {"src": "https://via.placeholder.com/640x480.png/001199?text=recusandae", "alt": "no image"}
        }]
    }],
    add(item, data) {
        item.children.push(data)
    }
})
