const hours = (new Date()).getHours();
document.documentElement.classList.add(
	hours < 5 ? "night" :
	hours < 6 ? "twilight" :
	hours < 20 ? "day" :
	hours < 21 ? "twilight" :
	"night"
);
