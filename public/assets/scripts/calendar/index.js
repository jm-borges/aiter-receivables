import { createRenderer } from './renderer.js';
import { createNavigation } from './navigation.js';
import { createState } from './state.js';

export function createCalendar(config) {
    if (!config.id) {
        throw new Error('Calendar precisa de um config.id');
    }

    const state = createState(config);
    const renderer = createRenderer(state, config);
    const navigation = createNavigation(state, renderer, config);

    async function loadAndRender() {
        renderer.showLoading();

        try {
            await state.load();
            renderer.build();
        } finally {
            renderer.hideLoading();
        }
    }

    return {
        async render() {
            await loadAndRender();
            navigation.bind();
        },

        async reload(newContext = null) {
            if (newContext) {
                state.setContext(newContext);
            }

            await loadAndRender();
        },

        reset() {
            state.clear();
            renderer.clear();
        },

        destroy() {
            navigation.unbind();
            renderer.clear();
        }
    };
}
