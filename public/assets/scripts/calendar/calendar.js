import { getDomRefs } from './dom.js';
import { createRenderer } from './renderer.js';
import { createDataLoader } from './dataLoader.js';
import { createNavigation } from './navigation.js';
import { createModal } from './modal.js';

document.addEventListener('DOMContentLoaded', () => {

    const dom = getDomRefs();
    if (!dom) return;

    const renderer = createRenderer(dom);
    const dataLoader = createDataLoader(renderer);
    const navigation = createNavigation(dom, renderer);
    const modal = createModal(dom, dataLoader);

    navigation.bind();
    modal.bind();

});
