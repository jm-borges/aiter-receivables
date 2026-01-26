export function createNavigation(state, renderer, config) {
    let prevBtn, nextBtn;

    const baseId = config.id;

    return {
        bind() {
            prevBtn = document.getElementById(`${baseId}-calendar-prev-month`);
            nextBtn = document.getElementById(`${baseId}-calendar-next-month`);

            prevBtn.addEventListener('click', () => {
                state.currentDate.setMonth(state.currentDate.getMonth() - 1);
                renderer.build();
            });

            nextBtn.addEventListener('click', () => {
                state.currentDate.setMonth(state.currentDate.getMonth() + 1);
                renderer.build();
            });
        },

        unbind() {
            prevBtn?.replaceWith(prevBtn.cloneNode(true));
            nextBtn?.replaceWith(nextBtn.cloneNode(true));
        }
    };
}
