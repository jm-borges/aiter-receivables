import { state } from './state.js';

export function createNavigation(dom, renderer) {
    return {
        changeMonth(delta) {
            state.currentDate.setMonth(state.currentDate.getMonth() + delta);
            renderer.build();
        },

        bind() {
            dom.prevBtn.addEventListener('click', () => this.changeMonth(-1));
            dom.nextBtn.addEventListener('click', () => this.changeMonth(1));
        }
    };
}
