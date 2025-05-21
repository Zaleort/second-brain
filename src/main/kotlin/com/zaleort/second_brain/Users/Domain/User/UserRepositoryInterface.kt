package com.zaleort.second_brain.Users.Domain.User

interface UserRepositoryInterface {
    fun findById(id: UserId): User?
    fun findByEmail(email: UserEmail): User?
    fun save(user: User)
    fun delete(id: UserId)
}