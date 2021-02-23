import React, {Component} from 'react';

class Categories extends Component {
    constructor() {
        super();
        this.state = {
            users: [],
            loading: true,
            step: false
        };
    }

    render() {
        return (
            <div>
                <div className="setting">
                    <div className="headSetting">
                        <span>Ignorer</span>
                    </div>

                    <div className="boxPosition">
                        <h1>Categories</h1>
                        <p>Personnalisez maintenant vos profils à votre goût.</p>

                    </div>
                </div>
            </div>
        )
    }
}

export default Categories;