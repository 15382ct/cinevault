// CineVault - Main JS

// Star rating selector (interactive hover)
document.addEventListener('DOMContentLoaded', () => {
    const labels = document.querySelectorAll('#starSelector label');
    labels.forEach((label, i) => {
        label.addEventListener('mouseover', () => {
            labels.forEach((l, j) => {
                l.style.color = j >= labels.length - 1 - i ? '#f1c40f' : 'var(--border)';
            });
        });
        label.addEventListener('mouseleave', () => {
            const checked = document.querySelector('#starSelector input:checked');
            labels.forEach((l, j) => {
                if (checked) {
                    const val = parseInt(checked.value);
                    l.style.color = j >= labels.length - val ? '#f1c40f' : 'var(--border)';
                } else {
                    l.style.color = 'var(--border)';
                }
            });
        });
    });
});
