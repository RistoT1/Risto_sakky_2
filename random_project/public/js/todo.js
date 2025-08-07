export class todo {
    constructor(taskInput, container) {
        this.taskInput = taskInput;
        this.container = container;
    }
    async add() {
        let ul = this.container.querySelector("ul");
        if (!ul) {
            ul = document.createElement("ul");
            this.container.append(ul);
        }

        const li = document.createElement("li");
        li.textContent = this.taskInput.value;
        ul.append(li);
    }
}


