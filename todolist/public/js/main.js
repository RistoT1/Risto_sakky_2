import {todo} from "./todo.js";

const button = document.querySelector(".submit_btn");
const task = document.querySelector(".todo_text");
const todo_container = document.querySelector(".todo_submitted");

const todoapp = new todo(task,todo_container);

button.addEventListener('click', e => {
    todoapp.add(task, todo_container);
})