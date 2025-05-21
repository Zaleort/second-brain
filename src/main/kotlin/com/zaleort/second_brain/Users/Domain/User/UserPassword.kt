package com.zaleort.second_brain.Users.Domain.User

data class UserPassword(val value: String) {
    override fun toString(): String {
        return value
    }
}
