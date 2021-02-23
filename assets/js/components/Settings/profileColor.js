import React, {Component} from 'react';
import ColorSelect from "./colorSelect";

class profileColor extends Component {
    componentDidMount() {
        this.getColorSelected();
    }

    getColorSelected() {
        document.querySelector("#user" + this.props.user.id + " ." + this.props.user.color).classList.add('selected');
    }

    render() {
        const arrayColors = ['blue', 'red', 'green', 'yellow', 'purple', 'new']

        return (
            <div className="marginFlex colorProfile" id={"user" + this.props.user.id}>
                <h2>{this.props.user.name}</h2>
                <p>Sélectionnez votre couleur</p>
                <div className="colorBar">
                    {arrayColors.map(color =>
                        <ColorSelect key={color} color={color} userId={this.props.user.id} />
                    )}
                </div>
            </div>
        )
    }
}

export default profileColor;