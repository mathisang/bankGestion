import React, {Component} from 'react';

class colorSelect extends Component {
    changeColorUser(color) {
        const colorBloc = document.querySelectorAll("#user" + this.props.userId + " .color")
        for (let i = 0; i < colorBloc.length; i++) {
            colorBloc[i].classList.remove("selected");
        }

        document.querySelector("#user" + this.props.userId + " ."+color).classList.add("selected");
    }

    render() {
        return (
            <div className={`color ${this.props.color}`} onClick={() => this.changeColorUser(this.props.color)}/>
        )
    }
}

export default colorSelect;